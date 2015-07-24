<?php
/**
 * @version    1.5
 * @package    Ferado
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */

if ( ! class_exists( 'WR_Sample_Data_Installer' ) ) :

/**
 * Sample data installer class.
 *
 * @since    1.0
 * @package  Ferado
 */
class WR_Sample_Data_Installer {
	/**
	 * Define Ajax action.
	 *
	 * @var  string
	 */
	const AJAX_ACTION = 'wr-sample-data-installer';

	/**
	 * Define server where sample data package is stored.
	 *
	 * @var  string
	 */
	const SERVER = 'http://www.woorockets.com/files/sampledata/';

	/**
	 * Define Ajax task that do not require login privilege.
	 *
	 * @var  array
	 */
	protected static $nopriv_task = array( 'download-asset', 'remove-assets', 'upload-asset' );

	/**
	 * Constructor.
	 *
	 * @return  void
	 */
	public function __construct() {
		global $pagenow;

		switch ( $pagenow ) {
			case 'customize.php' :
				// Register action to load required assets
				add_action( 'customize_controls_enqueue_scripts', array( &$this, 'enqueue_assets' ) );

				// Print HTML code for sample data installer modal
				add_action( 'customize_controls_print_footer_scripts', array( &$this, 'print_html' ) );
			break;

			case 'admin-ajax.php' :
				// Register Ajax action
				add_action( 'wp_ajax_'        . self::AJAX_ACTION, array( &$this, 'execute' ) );
				add_action( 'wp_ajax_nopriv_' . self::AJAX_ACTION, array( &$this, 'execute' ) );

				// Increase maximum execution time
				if ( ! ini_get( 'safe_mode' ) ) {
					if ( function_exists( 'set_time_limit' ) ) {
						set_time_limit( 0 );
					}
				}

				// Initialize WordPress Filesystem Abstraction
				global $wp_filesystem;

				if ( ! function_exists( 'WP_Filesystem' ) ) {
					include_once ABSPATH . 'wp-admin/includes/file.php';
				}

				if ( ! $wp_filesystem ) {
					WP_Filesystem();
				}

				$this->wp_filesystem = $wp_filesystem;

				// Initialize WordPress Plugin Upgrader
				class_exists( 'Plugin_Upgrader' ) || include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

				function_exists( 'screen_icon'     ) || include_once ABSPATH . 'wp-admin/includes/screen.php';
				function_exists( 'show_message'    ) || include_once ABSPATH . 'wp-admin/includes/misc.php';
				function_exists( 'get_plugin_data' ) || include_once ABSPATH . 'wp-admin/includes/plugin.php';

				// Get theme data
				$theme = wp_get_theme();

				// Store theme ID and name for later reference
				$this->name = $theme['Name'];
				$this->id   = strtolower( $theme['Name'] );
			break;
		}
	}

	/**
	 * Enqueue required assets for sample data installer.
	 *
	 * @return  void
	 */
	public function enqueue_assets() {
		// Load required assets
		wp_enqueue_style(  'wr-bootstrap'            , get_template_directory_uri() . '/assets/css/vendor/bootstrap.min.css' );
		wp_enqueue_script( 'wr-bootstrap'            , get_template_directory_uri() . '/assets/js/vendor/bootstrap.min.js'   );
		wp_enqueue_script( 'wr-sample-data-installer', get_template_directory_uri() . '/assets/js/sample-data-installer.js'  );
	}

	/**
	 * Print HTML code for sample data installer modal.
	 *
	 * @return  void
	 */
	public function print_html() {
		?>
		<div id="wr-install-sample-data-modal" class="wr-bootstrap">
			<div class="modal fade" role="dialog" data-backdrop="static" aria-labelledby="wr-install-sample-data-modal-label" aria-hidden="true" style="display:none">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="wr-install-sample-data-modal-label">
								<span class="install hide"><?php _e( 'Install Sample Data', 'ferado' ); ?></span>
								<span class="restore hide"><?php _e( 'Restore Original Data', 'ferado' ); ?></span>
							</h4>
						</div>
						<div class="modal-body"></div>
						<div class="modal-footer">
							<button class="button-primary btn-install disabled" type="button">
								<span class="install hide"><?php _e( 'Install Sample Data', 'ferado' ); ?></span>
								<span class="restore hide"><?php _e( 'Restore Original Data', 'ferado' ); ?></span>
								<span class="continue hide"><?php _e( 'Continue', 'ferado' ); ?></span>
								<span class="finish hide"><?php _e( 'Finish', 'ferado' ); ?></span>
							</button>
							<button class="button-secondary btn-cancel" type="button"><?php _e( 'Cancel', 'ferado' ); ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo '<scr' . 'ipt>'; ?>
			new jQuery.WR_Sample_Data_Installer({
				ajax_url: '<?php echo esc_url( admin_url( 'admin-ajax.php?action=wr-sample-data-installer' ) ); ?>',
				base_url: '<?php echo esc_url( admin_url() ); ?>',
			});
		<?php echo '</scr' . 'ipt>';
	}

	/**
	 * Execute Ajax action.
	 *
	 * @return  void
	 */
	public function execute() {
		// Get task
		$task = isset( $_REQUEST['task'] ) ? $_REQUEST['task'] : null;

		if ( empty( $task ) ) {
			return false;
		}

		// Verify login privilege
		global $wp_current_filter;

		$doing_action = current( array_reverse( $wp_current_filter ) );
		$is_nopriv    = ( 0 === strpos( $doing_action, 'wp_ajax_nopriv_' ) );

		if ( $is_nopriv && ! in_array( $task, self::$nopriv_task ) ) {
			return false;
		}

		// Check if task has template file
		$template = substr( __FILE__, 0, -4 ) . "/{$task}.php";

		if ( ! @file_exists( $template ) || ! @is_file( $template ) ) {
			$template = null;
		}

		// Preset result
		$data = false;

		// Execute task if method exists
		$method = str_replace( '-', '_', $task ) . '_action';

		if ( method_exists( $this, $method ) ) {
			try {
				$data = call_user_func( array( $this, $method ) );
			} catch ( Exception $e ) {
				$data = $e;
			}

			// Verify return data
			if ( false === $data ) {
				exit (
					json_encode(
						array(
							'status' => 'failure',
							'data'   => null,
						)
					)
				);
			} elseif ( is_wp_error( $data ) ) {
				exit (
					json_encode(
						array(
							'status' => 'failure',
							'data'   => $data->get_error_message(),
						)
					)
				);
			} elseif ( is_a( $data, 'Exception' ) ) {
				exit (
					json_encode(
						array(
							'status' => 'failure',
							'data'   => $data->getMessage(),
						)
					)
				);
			}
		}

		// Load template file if exists
		if ( ! empty( $template ) ) {
			// Load template file
			ob_start();

			include $template;

			$html = ob_get_clean();

			if ( ! empty( $html ) ) {
				$data = $html;
			}
		}

		// Prepare response data
		if ( empty( $data ) || is_scalar( $data ) || ( is_array( $data ) && ! isset( $data['status'] ) ) || ( is_object( $data ) && ! isset( $data->status ) ) ) {
			$data = array(
				'status' => 'success',
				'data'   => $data,
			);
		}

		// Exit immediately to prevent WordPress from processing further
		exit( json_encode( $data ) );
	}

	/**
	 * User confirmed action.
	 *
	 * @return  void
	 */
	protected function confirmed_action() {
		// Generate link to download sample data package
		$link = self::SERVER . str_replace( '-', '_', $this->id ) . '_sample_data.zip';

		return $link;
	}

	/**
	 * Download action.
	 *
	 * @return  mixed  Either an array of plugins or null.
	 */
	protected function download_action() {
		try {
			// Download sample data package if necessary
			if ( ! isset( $_GET['uploaded'] ) || ! ( int ) $_GET['uploaded'] ) {
				// Generate path to store downloaded sample data package
				$path = wp_upload_dir();
				$path = $path['basedir'] . '/' . $this->id . '-sample-data.zip';

				// Generate link to download sample data package
				$link = self::SERVER . str_replace( '-', '_', $this->id ) . '_sample_data.zip';

				// Download sample data package
				$this->_download( $link, $path );
			}

			// Get sample data XML declaration
			$xml = $this->_parse_sample_data();

			if ( is_string( $xml ) ) {
				// Get current and latest theme version
				list( $current, $latest ) = explode( '<>', $xml );

				// Clean-up
				$this->_clean_temporary_data();

				return array(
					'status' => 'outdate',
					'data'   => sprintf(
						__( 'The theme version %1$s you are using is outdated. You need to update theme to the latest version %2$s before installing sample data.', 'ferado' ),
						$current,
						$latest
					)
				);
			}

			// Parse sample data declaration for dependencies
			foreach ( $xml->xpath( '//product/extension[@downloadurl]' ) as $plugin ) {
				$pluginAttrs = ( array ) $plugin->attributes();
				$pluginAttrs = $pluginAttrs['@attributes'];

				$pluginAttrs['version']      = isset( $pluginAttrs['version'] ) ? $pluginAttrs['version'] : '';
				$pluginAttrs['state']        = $this->_get_plugin_state( ( string ) $pluginAttrs['name'], ( string ) $pluginAttrs['version'] );
				$pluginAttrs['dependencies'] = array();

				if ( isset( $plugin->dependency ) && isset( $plugin->dependency->parameter ) ) {
					foreach ( $plugin->dependency->parameter as $name ) {
						if ( empty( $name ) ) {
							continue;
						}

						// Get dependency data
						$dependency = $xml->xpath( '//product/extension[@name="' . $name . '"]' );

						if ( ! $dependency || ! @count( $dependency ) ) {
							continue;
						}

						$dependency = current( $dependency );

						$dependencyAttrs = ( array ) $dependency->attributes();
						$dependencyAttrs = $dependencyAttrs['@attributes'];

						$dependencyAttrs['state'] = $this->_get_plugin_state( ( string ) $dependencyAttrs['name'], ( string ) $dependencyAttrs['version'] );

						if ( 'installed' != $dependencyAttrs['state'] ) {
							$pluginAttrs['dependencies'][] = $dependencyAttrs;
						}
					}
				}

				if ( 'installed' != $pluginAttrs['state'] || count( $pluginAttrs['dependencies'] ) ) {
					if ( isset( $pluginAttrs['required'] ) && ( 1 == ( int ) $pluginAttrs['required'] || 'true' == ( string ) $pluginAttrs['required'] ) ) {
						$plugins['required'][] = $pluginAttrs;
					} else {
						$plugins['optional'][] = $pluginAttrs;
					}
				}
			}

			return isset( $plugins ) ? $plugins : null;
		} catch ( Exception $e ) {
			throw $e;
		}
	}

	/**
	 * Upload action.
	 *
	 * @return  void
	 */
	protected function upload_action() {
		try {
			if ( ! isset( $_FILES['package'] ) || 0 != $_FILES['package']['error'] ) {
				throw new Exception( __( 'File upload failed.', 'ferado' ) );
			}

			// Generate path to store downloaded sample data package
			$path = wp_upload_dir();
			$path = $path['basedir'] . '/' . $this->id . '-sample-data.zip';

			// Move uploaded file to temporary location
			if ( ! move_uploaded_file( $_FILES['package']['tmp_name'], $path ) ) {
				throw new Exception( __( 'File upload failed.', 'ferado' ) );
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Upload asset action.
     *
     * @return  void
     */
    protected function upload_asset_action() {
        try {
            if (!isset($_FILES['package']) || 0 != $_FILES['package']['error']) {
                throw new Exception(__('File upload failed.', 'ferado'));
            }

            // Generate path to store downloaded sample data package
            $path = wp_upload_dir();
            $file = $path['basedir'] . '/' . $this->id . '-asset.zip';
            $path_extract = $path['basedir'] ;

            // Move uploaded file to temporary location
            if ( !move_uploaded_file($_FILES['package']['tmp_name'], $file ) ) {
                throw new Exception(__('File upload failed.', 'ferado'));
            } else {
                $result = unzip_file( $file, $path['basedir'] . '/wr-asset-search-json' );
                if ( is_wp_error($result ) ) {
                    throw new Exception(sprintf(__('Unable to extract sample data package: %s', 'ferado'), $result->get_error_message()));
                } else {

                    $this->copy_dir( $path['basedir'] . '/wr-asset-search-json', $path['basedir'] . '/' );

                    // Remove file zip asset
                    $this->wp_filesystem->delete($file, false, 'f');
                    $this->wp_filesystem->delete( $path['basedir'] . '/wr-asset-search-json', true, 'd' );

                }
			}
		} catch ( Exception $e ) {
			throw $e;
		}
	}

	/**
    * Copies a directory from one location to another via the WordPress Filesystem Abstraction.
    * Assumes that WP_Filesystem() has already been called and setup.
    *
    * @since 2.5.0
    *
    * @param string $from source directory
    * @param string $to destination directory
    * @param array $skip_list a list of files/folders to skip copying
    * @return mixed WP_Error on failure, True on success.
    */
    function copy_dir($from, $to, $skip_list = array() ) {
        global $wp_filesystem;

        $dirlist = $wp_filesystem->dirlist($from);

        $from = trailingslashit($from);
        $to = trailingslashit($to);

        foreach ( (array) $dirlist as $filename => $fileinfo ) {
            if ( in_array( $filename, $skip_list ) )
                continue;

            if ( 'f' == $fileinfo['type'] ) {

            	if ( !@is_file( $to . $filename ) ) {
                    if ( ! $wp_filesystem->copy($from . $filename, $to . $filename, false, FS_CHMOD_FILE) ) {
                        // If copy failed, chmod file to 0644 and try again.
                        $wp_filesystem->chmod( $to . $filename, FS_CHMOD_FILE );
                        if ( ! $wp_filesystem->copy($from . $filename, $to . $filename, false, FS_CHMOD_FILE) )
                            throw new Exception( __( 'Could not copy file.', 'ferado' ) );

                    }
                }
            } elseif ( 'd' == $fileinfo['type'] ) {
                if ( !$wp_filesystem->is_dir($to . $filename) ) {
                    if ( !$wp_filesystem->mkdir($to . $filename, FS_CHMOD_DIR) )
                        throw new Exception( __( 'Could not create directory.', 'ferado' ) );
                }

                // generate the $sub_skip_list for the subdirectory as a sub-set of the existing $skip_list
                $sub_skip_list = array();
                foreach ( $skip_list as $skip_item ) {
                    if ( 0 === strpos( $skip_item, $filename . '/' ) )
                        $sub_skip_list[] = preg_replace( '!^' . preg_quote( $filename, '!' ) . '/!i', '', $skip_item );
                }

                $result = $this->copy_dir($from . $filename, $to . $filename, $sub_skip_list);
                if ( is_wp_error($result) )
                    return $result;
            }
        }
        return true;
    }

	/**
	 * Install plugin action.
	 *
	 * @return  void
	 */
	protected function install_plugin_action() {
		try {
			// Get plugin being installed
			$plugin = isset( $_GET['plugin'] ) ? $_GET['plugin'] : null;

			if ( empty( $plugin ) ) {
				throw new Exception( __( 'Missing parameter.', 'ferado' ) );
			}

			// Get sample data XML declaration
			$xml = $this->_parse_sample_data();

			// Get plugin details
			$plugin = $xml->xpath( '//product/extension[@name="' . $plugin . '"]' );
			$plugin = current( $plugin );
			$state  = $this->_get_plugin_state( ( string ) $plugin['name'], ( string ) $plugin['version'] );

			if ( 'installed' != $state ) {
				// Generate path to store downloaded plugin package
				$path = wp_upload_dir();
				$path = $path['basedir'] . '/' . $this->id . '-sample-data/' . str_replace( ' ', '-', ( string ) $plugin['name'] ) . '.zip';

				// Download requested plugin package
				$valid_headers = array(
					'content-type' => array(
						'application/zip',
						'application/x-zip',
						'application/x-zip-compressed',
						'application/octet-stream',
						'application/x-compress',
						'application/x-compressed',
						'multipart/x-zip',
					)
				);

				$this->_download( ( string ) $plugin['downloadurl'], $path, $valid_headers );

				// Init WordPress Plugin Upgrader
				$upgrader = new Plugin_Upgrader();

				if ( 'update' == $state ) {
					// Get relative path to plugin's main file
					$plugin = $this->_get_plugin_path( ( string ) $plugin['name'] );

					// Let WordPress upgrade requested plugin
					add_filter( 'upgrader_pre_install'      , array( $upgrader, 'deactivate_plugin_before_upgrade' ), 10, 2 );
					add_filter( 'upgrader_clear_destination', array( $upgrader, 'delete_old_plugin'                ), 10, 4 );

					$upgrader->run(
						array(
							'package'           => $path,
							'destination'       => WP_PLUGIN_DIR,
							'clear_destination' => true,
							'clear_working'     => true,
							'hook_extra'        => array(
								'plugin' => $plugin,
								'type'   => 'plugin',
								'action' => 'update',
							),
						)
					);

					// Cleanup our hooks, in case something else does a upgrade on this connection.
					remove_filter( 'upgrader_pre_install'      , array( $upgrader, 'deactivate_plugin_before_upgrade' ) );
					remove_filter( 'upgrader_clear_destination', array( $upgrader, 'delete_old_plugin'                ) );

					if ( ! $upgrader->result || is_wp_error( $upgrader->result ) ) {
						throw new Exception(
							sprintf(
								__( 'Upgrade plugin failed: %s', 'ferado' ),
								$upgrader->result ? $upgrader->result->get_error_message() : __( 'Unknown reason', 'ferado' )
							)
						);
					}

					// Force refresh of plugin update information
					if ( function_exists( 'wp_clean_plugins_cache' ) ) {
						wp_clean_plugins_cache( true );
					}
				} else {
					// Let WordPress install requested plugin
					$result = $upgrader->install( $path );

					if ( ! $result || is_wp_error( $result ) ) {
						throw new Exception(
							sprintf(
								__( 'Plugin installation failed: %s', 'ferado' ),
								$result ? $result->get_error_message() : __( 'Unknown reason', 'ferado' )
							)
						);
					}

					// Get relative path to plugin's main file
					$plugin = $this->_get_plugin_path( ( string ) $plugin['name'] );

					// Let WordPress activate the newly installed plugin
					$result = activate_plugin( $plugin, '', is_network_admin(), true );

					if ( is_wp_error( $result ) && 'unexpected_output' != $result->get_error_code() ) {
						throw new Exception( sprintf( __( 'Plugin activation failed: %s', 'ferado' ), $result->get_error_message() ) );
					}
				}
			}
		} catch ( Exception $e ) {
			throw $e;
		}
	}

	/**
	 * Import sample data action.
	 *
	 * @return  mixed  Either an array of skipped plugins or null.
	 */
	protected function import_data_action() {
		global $wpdb, $table_prefix;

		try {
			// Get current home and site URL
			$siteurl = call_user_func( 'get_option', 'siteurl' );
			$home    = call_user_func( 'get_option', 'home'    );

			// Get session tokens of current user
			$session_tokens = get_user_meta( get_current_user_id(), 'session_tokens', true );

			// Get path to sample data XML declaration file
			$xml = $this->_extract_package();

			// Parse sample data package
			$xml = $this->_parse_sample_data();

			// Get all tables in database
			$existing_tables = $wpdb->get_results( 'SHOW TABLES;', ARRAY_N );

			foreach ( $existing_tables as & $existing_table ) {
				$existing_table = $existing_table[0];
			}

			// Pre-define database backup queries
			$backups = array();

			foreach ( $xml->xpath( '//product/extension' ) as $plugin ) {
				// Check plugin installation state
				if ( 'wordpress' != $plugin['name'] && isset( $plugin['downloadurl'] ) ) {
					$pluginAttrs = ( array ) $plugin->attributes();
					$pluginAttrs = $pluginAttrs['@attributes'];

					$pluginAttrs['version'] = isset( $pluginAttrs['version'] ) ? $pluginAttrs['version'] : '';
					$pluginAttrs['state']   = $this->_get_plugin_state( ( string ) $pluginAttrs['name'], ( string ) $pluginAttrs['version'] );

					if ( 'installed' != $pluginAttrs['state'] ) {
						$skipped_plugins[] = $pluginAttrs;

						continue;
					}

					// Store installed plugins
					$installed_plugins[ ( string ) $pluginAttrs['name'] ] = $pluginAttrs;
				}

				// Backup current plugin data
				$tables = $plugin->xpath( 'task[@name="dbbackup"]/parameters/parameter' );

				if ( $tables && count( $tables ) ) {
					foreach ( $tables as $table ) {
						// Set real table prefix
						if ( '#__' == substr( $table, 0, 3 ) ) {
							$table = str_replace( '#__', $table_prefix, $table );
						} elseif ( 'wp_' == substr( $table, 0, 3 ) && 'wp_' != $table_prefix ) {
							$table = str_replace( 'wp_', $table_prefix, $table );
						} else {
							$table = $table_prefix . $table;
						}

						// Make sure table exists in database
						if ( ! in_array( $table, $existing_tables ) ) {
							continue;
						}

						// Drop existing table first
						$backups[] = "DROP TABLE IF EXISTS `{$table}`;";

						// Get table creation schema
						$results   = $wpdb->get_results( "SHOW CREATE TABLE `{$table}`;", ARRAY_A );
						$results   = str_replace( 'CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $results[0]['Create Table'] );
						$backups[] = str_replace( "\n", '', $results ) . ';';

						// Get table data
						$results = $wpdb->get_results( "SELECT * FROM `{$table}` WHERE 1;", ARRAY_A );

						foreach ( $results as $result ) {
							// Generate column list
							$keys = '(`' . implode( '`, `', array_keys( $result ) ) . '`)';

							// Generate value list
							$values = array();

							foreach ( array_values( $result ) as $value ) {
								$values[] = str_replace( array( '\\', "\r", "\n", "'" ), array( '\\\\', '\\r', '\\n', "\\'" ), $value );
							}

							$values = "('" . implode( "', '", $values ) . "')";

							// Store insert query
							$backups[] = "INSERT INTO `{$table}` {$keys} VALUES {$values};";
						}
					}
				}

				// Import sample plugin data
				$queries = $plugin->xpath( 'task[@name="dbinstall"]/parameters/parameter' );

				if ( $queries && count( $queries ) ) {
					foreach ( $queries as $query ) {
						// Get table name
						$pattern = '/(DROP TABLE IF EXISTS|DROP TABLE|CREATE TABLE IF NOT EXISTS|CREATE TABLE|DELETE FROM|INSERT INTO)\s+`*([^`\s]+)`*/i';

						if ( ! preg_match( $pattern, $query, $match ) ) {
							continue;
						}

						$table = $match[2];

						// Set real table prefix
						if ( '#__' == substr( $table, 0, 3 ) ) {
							$table = str_replace( '#__', $table_prefix, $table );
						} elseif ( 'wp_' == substr( $table, 0, 3 ) && 'wp_' != $table_prefix ) {
							$table = str_replace( 'wp_', $table_prefix, $table );
						} else {
							$table = $table_prefix . $table;
						}

						// Alter query with real table name
						$query = str_replace( $match[0], "{$match[1]} `{$table}`", $query );

						// Convert special characters in query to standard characters
						$query = $this->_convert_special_chars( $query );

						// Do not drop users table
						if ( false !== strpos( $query, 'DROP TABLE' ) && false !== strpos( $query, "{$table_prefix}users" ) ) {
							continue;
						}

						// Make sure table is being created only if not exist
						if ( false !== strpos( $query, 'CREATE TABLE' ) ) {
							if ( false === strpos( $query, 'IF NOT EXISTS' ) ) {
								$query = str_replace( 'CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $query );
							}

							// Update existing tables
							if ( ! in_array( $table, $existing_tables ) ) {
								$existing_tables[] = $table;
							}
						}

						// Check if this is an insert query
						elseif ( false !== strpos( $query, 'INSERT INTO' ) ) {
							// Make sure table exists in database
							if ( ! in_array( $table, $existing_tables ) ) {
								continue;
							}

							// Prepare insert query for postmeta table
							if ( false !== strpos( $query, "{$table_prefix}postmeta" ) ) {
								// Remove Google Analytics ID
								if ( false != strpos( $query, "'wr_page_options'," ) ) {
									$pattern = '/s:19:\\\"google_analytics_id\\\";s:13:\\\"[a-zA-Z0-9\-]+\\\";/';
									$query   = preg_replace( $pattern, 's:19:\\"google_analytics_id\\";s:0:\\"\\";', $query );
								}
							}

							// Prepare insert query for options table
							elseif ( false !== strpos( $query, "{$table_prefix}options" ) ) {
								// Parse query
								@list( $columns, $value                 ) = explode( 'VALUES', $query, 2 );
								@list( $id, $option, $value, $auto_load ) = explode(   "', '", $value, 4 );

								// Do not replace home and site URL
								if ( in_array( $option, array( 'siteurl', 'home' ) ) ) {
									// Set current home/site URL to query
									$query = str_replace( $value, ${$option}, $query );
								}

								// Update table prefix for user roles option
								if ( preg_match( '/^(#_|wp)_user_roles$/', $option ) ) {
									// Set correct table prefix to query
									$query = str_replace( $option, preg_replace( '/(#_|wp)_/', $table_prefix, $option ), $query );
								}

								// Remove Google Analytics ID
								if ( 'theme_mods_' . $this->id == $option ) {
									$pattern = '/s:(\d+):\\\"google_analytics_id([a-z_]+)\\\";s:13:\\\"[a-z0-9\-]+\\\";/i';
									$query   = preg_replace( $pattern, 's:\\1:\\"google_analytics_id\\2\\";s:0:\\"\\";', $query );
								}
							}

							// Prepare insert query for usermeta table
							elseif ( false !== strpos( $query, "{$table_prefix}usermeta" ) ) {
								// Parse query
								@list( $columns, $value           ) = explode( 'VALUES', $query, 2 );
								@list( $id, $uid, $option, $value ) = explode(   "', '", $value, 4 );

								// Update table prefix for user roles option
								if ( preg_match( '/^(#_|wp)_(capabilities|user_level)$/', $option ) ) {
									// Set correct table prefix to query
									$query = str_replace( $option, preg_replace( '/(#_|wp)_/', $table_prefix, $option ), $query );
								}
							}

							// Use insert ignore query instead of insert query for users table
							elseif ( false !== strpos( $query, "{$table_prefix}users" ) ) {
								$query = str_replace( 'INSERT INTO', 'INSERT IGNORE INTO', $query );
							}
						}

						// Check if query contains any demo asset
						$pattern = '#https?://(demo|rc)\.woorockets\.com/([^\s\'"]+)wp-content/uploads(/[^\s\'"]+)#i';

						if ( preg_match_all( $pattern, $query, $matches, PREG_SET_ORDER ) ) {
							// Get details about upload directory
							$upload = wp_upload_dir();

							foreach ( $matches as $match ) {
								// Clean \ character from the end of captured string
								$match[0] = rtrim( $match[0], '\\' );
								$match[3] = rtrim( $match[3], '\\' );

								// Generate path to store demo asset
								$path = $upload['basedir'] . $match[3];

								// Do not download if asset already exists
								if ( ! @is_file( $path ) ) {
									if ( false !== strpos( $query, "'attachment'," ) ) {
										if ( ! isset( $demo_assets[ $match[0] ] ) ) {
											// Store demo assets for download later
											$demo_assets[ $match[0] ] = array();
										}
									} elseif ( preg_match( '/-(\d+x\d+)\.[a-z0-9]{3,4}$/i', $match[3], $m ) ) {
										$origin = preg_replace( '/-(\d+x\d+)(\.[a-z0-9]{3,4})$/i', '\\2', $match[0] );

										if ( ! isset( $demo_assets[ $origin ] ) ) {
											$demo_assets[ $origin ] = array();
										}

										if ( ! in_array( $m[1], $demo_assets[ $origin ] ) ) {
											$demo_assets[ $origin ][] = $m[1];
										}
									}
								}

								// Update query with new asset URL
								$query = str_replace( $match[0], $upload['baseurl'] . $match[3], $query );
							}
						}

						// Check if query contains serialization string
						if ( preg_match( '/a:\d+:\{/', $query ) ) {
							$parts = explode( '";', $query );
							$query = '';
							$i     = 0;
							$n     = count( $parts );

							// Define call-back function
							if ( ! function_exists( 'woorockets_sample_data_installer_replace_callback' ) ) {
								function woorockets_sample_data_installer_replace_callback( $m ) {
									return $m[1] . strlen( $m[4] ) . $m[3] . $m[4] . $m[5];
								}
							}

							foreach ( $parts as $part ) {
								if ( ++$i < $n ) {
									$part .= '";';
								}

								if ( preg_match( '/^(.*)(s:\d+:\\\?".+\\\?";)(.*)$/', $part, $match ) ) {
									$match[2] = str_replace( array( '\\r', '\\n', "\\'", '\\"' ), array( '', '', "'", '"' ), $match[2] );

									$match[2] = preg_replace_callback(
										'/(s:)(\d+)(:")(.*)(";)/',
										'woorockets_sample_data_installer_replace_callback',
										$match[2]
									);

									$part = $match[1] . str_replace( array( "'", '"' ), array( "\\'", '\\"' ), $match[2] ) . $match[3];
								}

								$query .= $part;
							}
						}

						// Execute query
						ob_start();

						if ( false === $wpdb->query( $query ) ) {
							$error = ob_get_contents();

							throw new Exception(
								sprintf(
									__( 'Sample data import has encountered an error and cannot continue: %s', 'ferado' ),
									empty( $error ) ? $query : $error
								)
							);
						}

						ob_end_clean();
					}
				}
			}

			// Make sure database is up-to-date with current WordPress version
			if ( ! function_exists( 'wp_upgrade' ) ) {
				include ABSPATH . 'wp-admin/includes/upgrade.php';
			}

			wp_upgrade();

			// Restore session tokens for current user
			if ( $session_tokens ) {
				update_user_meta( get_current_user_id(), 'session_tokens', $session_tokens );
			}

			// Create database backup file if necessary
			if ( count( $backups ) ) {
				$backups = implode( "\n", $backups );

				// Get details about upload directory
				$path = isset( $upload ) ? $upload : wp_upload_dir();

				if ( $path = $this->_prepare_directory( $path['basedir'] . '/' . $this->id . '/backup' ) ) {
					// Generate backup file path
					$path = $path . '/' . date( 'Y-m-d H-i-s' ) . '.sql';

					// Write database backup to file
					$this->_write_file( $path, $backups );
				}
			}

			// Clean-up temporary file/directory left by sample data installation process
			$this->_clean_temporary_data();

			// Prepare installation results
			$path = isset( $upload ) ? $upload : wp_upload_dir();
			$path = $this->_prepare_directory( $path['basedir'] . '/' . $this->id );

			foreach ( array( 'installed_plugins', 'demo_assets' ) as $type ) {
				if ( isset( ${$type} ) ) {
					// Write installation results to file
					$this->_write_file( $path . '/' . $type . '.json', json_encode( ${$type} ) );
				}
			}

			// Prepare response
			$response = null;

			if ( isset( $skipped_plugins ) ) {
				$response['skipped_plugins'] = $skipped_plugins;
			}

			if ( isset( $demo_assets ) ) {
				// Set demo assets to reponse
				foreach ( array_keys( $demo_assets ) as $asset ) {
					$response['demo_assets'][] = basename( $asset );
				}
			}

			return $response;
		} catch ( Exception $e ) {
			throw $e;
		}
	}

	/**
	 * Download demo asset action.
	 *
	 * @return  void
	 */
	protected function download_asset_action() {
		// Get asset index
		$index = isset( $_GET['asset'] ) ? $_GET['asset'] : null;

		if ( is_null( $index ) ) {
			throw new Exception( __( 'Missing demo asset to download.', 'ferado' ) );
		}

		// Get details about upload directory
		$path = wp_upload_dir();

		if ( ! $this->wp_filesystem->exists( $path['basedir'] . '/' . $this->id . '/demo_assets.json' ) ) {
			throw new Exception( __( 'Missing list of demo assets to download.', 'ferado' ) );
		}

		// Load the list of demo assets to be downloaded
		$demo_assets = json_decode( $this->wp_filesystem->get_contents( $path['basedir'] . '/' . $this->id . '/demo_assets.json' ), true );
		$asset_links = array_keys( $demo_assets );

		if ( ! isset( $asset_links[ $index ] ) ) {
			throw new Exception( __( 'Missing demo asset to download.', 'ferado' ) );
		}

		// Parse asset URL
		$url     = $asset_links[ $index ];
		$pattern = '#https?://(demo|rc)\.woorockets\.com/([^\s\'"]+)wp-content/uploads(/[^\s\'"]+)#i';

		if ( ! preg_match( $pattern, $url, $match ) ) {
			throw new Exception( __( 'Invalid demo asset URL.', 'ferado' ) );
		}

		// Generate local asset path
		$path = $path['basedir'] . $match[3];

		try {
			// Generate other thumbnails and intermediate sizes used in sample data
			foreach ( $demo_assets[ $url ] as $s ) {
				// Generate download link and local path
				$thumb_url  = preg_replace( '/(\.[a-z0-9]{3,4})$/i', "-{$s}\\1", $url  );
				$thumb_path = preg_replace( '/(\.[a-z0-9]{3,4})$/i', "-{$s}\\1", $path );

				if ( ! @is_file( $thumb_path ) ) {
					$this->_download( $thumb_url, $thumb_path );
				}
			}

			// Download demo asset
			if ( ! @is_file( $path ) ) {
				try {
					$this->_download( $url, $path );

					if ( ! preg_match( '/-\d+x\d+\.[a-z0-9]{3,4}$/i', $match[3] ) ) {
						// Generate thumbnails and other intermediate sizes for downloaded demo asset
						global $_wp_additional_image_sizes;

						$sizes = array();

						foreach ( get_intermediate_image_sizes() as $s ) {
							// Check if thumbnail already exists
							$thumb_path = preg_replace( '/(\.[a-z0-9]{3,4})$/i', "-{$s}\\1", $path );

							if ( @is_file( $thumb_path ) ) {
								continue;
							}

							// Preset resize options
							$sizes[ $s ] = array( 'width' => '', 'height' => '', 'crop' => false );

							if ( isset( $_wp_additional_image_sizes[ $s ]['width'] ) ) {
								// Theme-added sizes
								$sizes[ $s ]['width'] = intval( $_wp_additional_image_sizes[ $s ]['width'] );
							} else {
								// Default sizes set in options
								$sizes[ $s ]['width'] = get_option( "{$s}_size_w" );
							}

							if ( isset( $_wp_additional_image_sizes[ $s ]['height'] ) ) {
								// Theme-added sizes
								$sizes[ $s ]['height'] = intval( $_wp_additional_image_sizes[ $s ]['height'] );
							} else {
								// Default sizes set in options
								$sizes[ $s ]['height'] = get_option( "{$s}_size_h" );
							}

							if ( isset( $_wp_additional_image_sizes[ $s ]['crop'] ) ) {
								// Theme-added sizes
								$sizes[ $s ]['crop'] = intval( $_wp_additional_image_sizes[ $s ]['crop'] );
							} else {
								// Default sizes set in options
								$sizes[ $s ]['crop'] = get_option( "{$s}_crop" );
							}
						}

						// Do resize
						$sizes = apply_filters( 'intermediate_image_sizes_advanced', $sizes );

						if ( $sizes ) {
							$editor = wp_get_image_editor( $path );

							if ( ! is_wp_error( $editor ) ) {
								$editor->multi_resize( $sizes );
							}
						}
					}
				} catch (Exception $e) {
					// Do nothing
				}
			}
		} catch ( Exception $e ) {
			throw new Exception( sprintf( __( 'Fail to download %1$s due to following error: %2$s', 'ferado' ), $url, $e->getMessage() ) );
		}
	}

	/**
	 * Confirm original data restoration action.
	 *
	 * @return  mixed  Array of plugin installed during sample data installation (if has any) or NULL.
	 */
	protected function restore_action() {
		// Get details about upload directory
		$path = wp_upload_dir();
		$path = $path['basedir'] . '/' . $this->id . '/installed_plugins.json';

		// Load the list of plugins to be deleted
		if ( $this->wp_filesystem->exists( $path ) ) {
			return array_values( json_decode( $this->wp_filesystem->get_contents( $path ), true ) );
		}

		return null;
	}

	/**
	 * Restore original data action.
	 *
	 * @return  void
	 */
	protected function restore_data_action() {
		// Check if we have any backup file?
		$path = wp_upload_dir();
		$path = $path['basedir'] . '/' . $this->id . '/backup';

		if ( count( $files = glob( "{$path}/*.sql" ) ) ) {
			// Sort by file name
			sort( $files );

			// Restore from oldest backup file
			$backup = array_shift( $files );
		}

		if ( isset( $backup ) ) {
			global $wpdb;

			// Get session tokens of current user
			$session_tokens = get_user_meta( get_current_user_id(), 'session_tokens', true );

			// Read backup file
			if ( $backup = $this->wp_filesystem->get_contents( $backup ) ) {
				$backup = explode( "\n", $backup );

				// Loop thru SQL queries and execute
				foreach ( $backup as $query ) {
					$wpdb->query( $query );
				}
			}

			// Restore session tokens for current user
			if ( $session_tokens ) {
				update_user_meta( get_current_user_id(), 'session_tokens', $session_tokens );
			}

			// It's time to clean-up
			$this->wp_filesystem->delete( $path, true );
		} else {
			throw new Exception( __( 'Not found any data backup file.', 'ferado' ) );
		}
	}

	/**
	 * Remove demo assets action.
	 *
	 * @return  void
	 */
	protected function remove_assets_action() {
		// Get details about upload directory
		$path = wp_upload_dir();

		if ( ! $this->wp_filesystem->exists( $path['basedir'] . '/' . $this->id . '/demo_assets.json' ) ) {
			return;
		}

		// Load the list of demo assets to be removed
		$demo_assets = json_decode( $this->wp_filesystem->get_contents( $path['basedir'] . '/' . $this->id . '/demo_assets.json' ), true );
		$asset_links = array_keys( $demo_assets );
		$pattern     = '#https?://(demo|rc)\.woorockets\.com/([^\s\'"]+)wp-content/uploads(/[^\s\'"]+)#i';

		foreach ( $asset_links as $url ) {
			// Parse asset URL
			if ( ! preg_match( $pattern, $url, $match ) ) {
				continue;
			}

			// Generate local demo asset path
			$asset = $path['basedir'] . $match[3];

			// Find all thumbnails belong to this asset
			if ( $thumbs = glob( preg_replace( '/\.[a-z0-9]{3,4}$/i', '-*.*', $asset ) ) ) {
				// Remove all thumbnails as well
				foreach ( $thumbs as $thumb ) {
					$this->wp_filesystem->delete( $thumb );
				}
			}

			// Remove demo asset
			$this->wp_filesystem->delete( $asset );
		}

		// Delete sample data installation results
		$this->wp_filesystem->delete( $path['basedir'] . '/' . $this->id . '/demo_assets.json' );
	}

	/**
	 * Delete plugin action.
	 *
	 * @return  void
	 */
	protected function delete_plugin_action() {
		// Get plugin index
		$index = isset( $_GET['plugin'] ) ? $_GET['plugin'] : null;

		if ( is_null( $index ) ) {
			throw new Exception( __( 'Missing plugin to delete.', 'ferado' ) );
		}

		// Get details about upload directory
		$path = wp_upload_dir();
		$path = $path['basedir'] . '/' . $this->id . '/installed_plugins.json';

		if ( ! $this->wp_filesystem->exists( $path ) ) {
			return;
		}

		// Load the list of demo assets to be downloaded
		$installed_plugins = array_values( json_decode( $this->wp_filesystem->get_contents( $path ), true ) );

		if ( isset( $installed_plugins[ $index ] ) ) {
			// Find plugin
			if ( $plugin = $this->_get_plugin_path( $installed_plugins[ $index ]['name'] ) ) {
				$result = delete_plugins( array( $plugin ) );

				if ( is_wp_error( $result ) ) {
					throw new Exception( $result->get_error_message() );
				}
			}
		}

		if ( $index + 1 == count( $installed_plugins ) ) {
			// Delete sample data installation results
			$this->wp_filesystem->delete( $path );
		}
	}

	/**
	 * Fetch a remote URI then return results.
	 *
	 * @param   string   $uri     Remote URI for fetching content.
	 * @param   string   $target  Local file path to store fetched content.
	 *
	 * @return  string
	 */
	private function _download( $uri, $target = '' ) {
		// Use WordPress API to download content from the given URI
		$result = download_url( $uri );

		if ( is_wp_error( $result ) ) {
			throw new Exception( $result->get_error_message() );
		}

		if ( ! empty( $target ) ) {
			// Prepare storage directory
			if ( ! $this->_prepare_directory( dirname( $target ) ) ) {
				throw new Exception( sprintf( __( 'Unable to create directory %s for storing downloaded file', 'ferado' ), dirname( $target ) ) );
			}

			// Create a local file by copying temporary file
			if ( ! $this->wp_filesystem->copy( $result, $target, true, FS_CHMOD_FILE ) ) {
				// If copy failed, chmod file to 0644 and try again
				$this->wp_filesystem->chmod( $target, 0644 );

				if ( ! $this->wp_filesystem->copy( $result, $target, true, FS_CHMOD_FILE ) ) {
					throw new Exception( sprintf( __( 'Unable to save downloaded file to %s', 'ferado' ), $target ) );
				}
			}

			$content = $this->wp_filesystem->size( $target );
		} else {
			$content = $this->wp_filesystem->get_contents( $result );
		}

		// Remove temporary file
		$this->wp_filesystem->delete( $result );

		return $content;
	}

	/**
	 * Create a directory if not already exists.
	 *
	 * @param   string  $path  Directory path.
	 *
	 * @return  mixed  Directory path on success, boolean FALSE otherwise.
	 */
	private function _prepare_directory( $path ) {
		// Create directory if not already exists
		if ( ! @is_dir( $path ) ) {
			$results = explode( '/', str_replace( '\\', '/', $path ) );
			$path    = array();

			while ( count( $results ) ) {
				$path[] = current( $results );

				if ( ! @is_dir( implode( '/', $path ) ) ) {
					$this->wp_filesystem->mkdir( implode( '/', $path ), 0755 );
				}

				// Shift paths
				array_shift( $results );
			}
		}

		// Re-build directory path
		$path = is_array( $path ) ? implode( '/', $path ) : $path;

		return @is_dir( $path ) ? $path : false;
	}

	/**
	 * Write given content to a local file.
	 *
	 * @param   string  $path     File path.
	 * @param   string  $content  Content to write.
	 *
	 * @return  boolean
	 */
	private function _write_file( $path, $content ) {
		$result = $this->wp_filesystem->put_contents( $path, $content );

		if ( ! $result ) {
			// If file creation failed, chmod file to 0644 and try again
			$this->wp_filesystem->chmod( $path, 0644 );

			$result = $this->wp_filesystem->put_contents( $path, $content );
		}

		return $result;
	}

	/**
	 * Extract sample data package.
	 *
	 * @return  string  Path to sample data XML declaration file.
	 */
	private function _extract_package() {
		// Generate path to store downloaded sample data package
		$path = wp_upload_dir();
		$path = $path['basedir'] . '/' . $this->id . '-sample-data';
		$file = "{$path}.zip";

		// Check if sample data package is already extracted
		if ( @is_dir( $path ) ) {
			// Search for XML file
			$xml = glob( "{$path}/*.xml" );

			if ( count( $xml ) ) {
				return current( $xml );
			}
		}

		// Extract downloaded sample data package
		$result = unzip_file( $file, $path );

		if ( is_wp_error( $result ) ) {
			throw new Exception( sprintf( __( 'Unable to extract sample data package: %s', 'ferado' ), $result->get_error_message() ) );
		}

		// Search for XML file
		$xml = glob( "{$path}/*.xml" );

		if ( count( $xml ) ) {
			return current( $xml );
		} else {
			throw new Exception( sprintf( __( 'Invalid sample data package: %s', 'ferado' ), __( 'XML file not found', 'ferado' ) ) );
		}
	}

	/**
	 * Parse sample data XML declaration.
	 *
	 * @return  object  An object instance of SimpleXmlElement class.
	 */
	private function _parse_sample_data() {
		try {
			// Get path to sample data XML declaration file
			$xml = $this->_extract_package();

			// Parse sample data XML declaration file
			$xml = simplexml_load_file( $xml );

			if ( ! $xml ) {
				throw new Exception( __( 'Unable to parse XML file for sample data declaration.', 'ferado' ) );
			}
		} catch ( Exception $e ) {
			throw $e;
		}

		// Get theme data
		$theme = wp_get_theme();

		// Check if sample data is compatible with installed theme
		$product = array(
			'id'      => isset( $xml['id'] )      ? ( string ) $xml['id']      : ( isset( $xml->product['id'] )      ? ( string ) $xml->product['id']      : null ),
			'name'    => isset( $xml['name'] )    ? ( string ) $xml['name']    : ( isset( $xml->product['name'] )    ? ( string ) $xml->product['name']    : null ),
			'version' => isset( $xml['version'] ) ? ( string ) $xml['version'] : ( isset( $xml->product['version'] ) ? ( string ) $xml->product['version'] : null ),
		);

		if ( empty( $product['id'] ) || $this->id != $product['id'] ) {
			if ( empty( $product['name'] ) || strcasecmp( $this->name, $product['name'] ) != 0 ) {
				throw new Exception(
					sprintf(
						__( 'Invalid sample data package: %s', 'ferado' ),
						__( 'Theme name in sample data package does not match the one installed', 'ferado' )
					)
				);
			}
		}

		// Check if sample data is compatible with installed theme version
		if ( ! empty( $product['version'] ) && version_compare( $theme->get( 'Version' ), $product['version'], '<' ) ) {
			return $theme->get( 'Version' ) . '<>' . $product['version'];
		}

		return $xml;
	}

	/**
	 * Get plugin state.
	 *
	 * @param   string  $plugin   Plugin name.
	 * @param   string  $version  Plugin version.
	 *
	 * @return  string  Either install, update or installed.
	 */
	private function _get_plugin_state( $plugin, $version = '' ) {
		// Get installed plugin list
		$wp_plugins = get_plugins();

		// Look for requested plugin
		if ( '.php' != substr( $plugin, -4 ) ) {
			$plugin = $this->_get_plugin_path( $plugin );
		}

		if ( array_key_exists( $plugin, $wp_plugins ) ) {
			if ( ! empty( $version ) && version_compare( $version, $wp_plugins[ $plugin ]['Version'], '>' ) ) {
				return 'update';
			} else {
				return 'installed';
			}
		}

		return 'install';
	}

	/**
	 * Get plugin path.
	 *
	 * @param   string   $name      Plugin name.
	 * @param   boolean  $abs_path  Whether to return absolute path instead of relative path.
	 *
	 * @return  string  Path to the plugin's main file.
	 */
	private function _get_plugin_path( $name, $abs_path = false ) {
		// Check if this plugin is installed
		$name       = strtolower( preg_replace( '/(\s|_)/', '-', trim( $name ) ) );
		$plugin     = null;
		$plugin_dir = WP_PLUGIN_DIR;

		if ( @is_file( "{$plugin_dir}/{$name}.php" ) ) {
			$plugin = "{$plugin_dir}/{$name}.php";
		}

		if ( ! $plugin && @is_file( "{$plugin_dir}/{$name}/main.php" ) ) {
			$plugin = "{$plugin_dir}/{$name}/main.php";
		}

		if ( ! $plugin && @is_file( "{$plugin_dir}/{$name}/{$name}.php" ) ) {
			$plugin = "{$plugin_dir}/{$name}/{$name}.php";
		}

		if ( $plugin && ! $abs_path ) {
			$plugin = str_replace( "{$plugin_dir}/", '', $plugin );
		}

		return $plugin;
	}

	/**
	 * Convert special characters in the given string to standard characters.
	 *
	 * @param   string  $string  String to convert.
	 *
	 * @return  string
	 */
	private function _convert_special_chars( $string ) {
		// Convert special quote characters to normal quotes
		$search = array(
			chr( 145 ),
			chr( 146 ),
			chr( 147 ),
			chr( 148 ),
			chr( 151 ),
		);

		$replace = array(
			"'",
			"'",
			'"',
			'"',
			'-',
		);

		$string = str_replace( $search, $replace, $string );

		// Remove all control and non-printable characters except new line, carriage return, tab and spacing
		return preg_replace( '/[^\x0A\x20-\x7E]/', '', $string );
	}

	/**
	 * Clean-up temporary file/directory left by sample data installation process.
	 */
	private function _clean_temporary_data() {
		// Generate path to store downloaded sample data package
		$path = wp_upload_dir();
		$path = $path['basedir'] . '/' . $this->id . '-sample-data';
		$file = "{$path}.zip";

		// It's time to clean-up
		$this->wp_filesystem->delete( $path, true );
		$this->wp_filesystem->delete( $file );
	}
}

// Instantiate sample data installer
$wr_sample_data_installer = new WR_Sample_Data_Installer();

endif;

