/**
 * @version    1.5
 * @package    Ferado
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */

(function($) {
	"use strict";

	$.WR_Sample_Data_Installer = function(params) {
		// Initialize parameters
		this.params = $.extend({
			ajax_url: 'admin-ajax.php?action=wr-sample-data-installer',
			base_url: '',
		}, params);

		// Initialize functionality
		this.init();
	};

	$.WR_Sample_Data_Installer.prototype = {
		init: function() {
			var self = this;

			// Append sample data installer container to document body
			$('#wr-install-sample-data-modal').appendTo(document.body);

			// Setup modal to install sample data
			self.modal = $('#wr-install-sample-data-modal .modal').on('show.bs.modal', function() {
				// Prepend backdrop
				var backdrop = (backdrop = $('.modal-backdrop')).length ? backdrop : $('<div class="modal-backdrop fade in" />');

				backdrop.insertBefore(self.modal);

				// Empty modal content
				self.modal.find('.modal-body').addClass('wr-loading').html('');

				// Reset buttons state
				self.install_button.addClass('disabled').attr('disabled', 'disabled').hide();
				self.cancel_button.show();
			}).on('hidden.bs.modal', function() {
				// Remove backdrop
				self.modal.prev('.modal-backdrop').remove();

				// Check if theme customizer needs to be refreshed
				if (self.reload_theme_customizer) {
					window.location.reload();
				}
			});

			// Get button to install sample data
			self.install_button = self.modal.find('button.btn-install');

			// Init button to cancel sample data installation
			self.cancel_button = self.modal.find('button.btn-cancel').bind('click', function(event) {
				event.preventDefault();

				// Hide modal
				self.modal.modal('hide');
			});

			// Set a flag if instal from upload package
    		self.install_from_upload_package = false;

			// Setup buttons to install sample data / restore original data
			$(document).on('click', '#wr-install-sample-data, #wr-restore-original-data', function() {
				var restore = $(this).attr('id') == 'wr-restore-original-data';

				// Set modal title
				self.modal.find('#wr-install-sample-data-modal-label').children().addClass('hide').filter(restore ? '.restore' : '.install').removeClass('hide');

				// Show modal
				self.modal.modal('show');

				// Load confirmation screen
				$.getJSON(
					self.params.ajax_url + '&task=' + (restore ? 'restore' : 'confirm'),
					function(response) {
						// Show confirmation screen
						self.modal.find('.modal-body').removeClass('wr-loading').html(response.data);

						// Setup buttons
						self.start(restore);
					}
				);
			});
		},

		start: function(restore) {
			var self = this;

			// Handle confirmation action
			self.modal.find('#wr-confirm-agreement').click(function() {
				if (this.checked) {
					self.install_button.removeClass('disabled').removeAttr('disabled');
				} else {
					self.install_button.addClass('disabled').attr('disabled', 'disabled');
				}
			});

			if (restore) {
				self.restore();
			} else {
				// Init button to load sample data installation screen
				self.install_button.unbind('click').bind('click', function(event) {
					event.preventDefault();

					// Load install sample data form
					var install_from = $('input[name="install_from"]:checked').val();

					$.getJSON(
						self.params.ajax_url + '&task=confirmed&install_from=' + install_from,
						function(response) {
							// Show sample data installation screen
							self.modal.find('.modal-body').html(response.data);

							// Toggle button state
							self.install_button.hide();

							// Check if install from local package
							if (install_from == 'downloaded_package') {
								// Show manual install form
								self.manualInstall();

								// Set a flag instal from upload package
								self.install_from_upload_package = true;
							} else {
								// Start download sample data package
								self.download();
							}
						}
					);
				}).show().children().addClass('hide').filter('.install').removeClass('hide');
			}
		},

		download: function(upload) {
			var	self = this,
				download = upload || $('#wr-install-sample-data-download-package');

			// Download sample data package
			$.getJSON(
				self.params.ajax_url + '&task=download' + (upload ? '&uploaded=1' : ''),
				function(response) {
					// Indicate that download step is completed
					download.addClass('wr-complete');

					if (response.status != 'success') {
						// Switch status
						download.find('.wr-loading').removeClass('wr-loading').addClass('wr-icon-remove');

						if (response.status == 'outdate' || upload) {
							// Show failure message box
							self.finish('failure', response.data);
						} else {
							// Show error message
							download.find('.wr-status').html(response.data).removeClass('hide');

							// Switch to manual installation mode
							self.manualInstall();
						}
					} else {
						// Switch status
						download.find('.wr-loading').removeClass('wr-loading').addClass('wr-icon-ok');

						if (response.data != '' && response.data != null) {
							// Process plugins list
							self.processPlugins(response.data);
						} else {
							// Start importing sample data
							self.import();
						}
					}
				}
			);
		},

		manualInstall: function() {
			var	self = this,
				upload = $('#wr-install-sample-data-upload-package'),
				manualInstall = $('#wr-install-sample-data-manually');
			
			// Show manual sample data installation form
            manualInstall.removeClass('hide');

            // Init button to continue manual sample data installation
            self.install_button.unbind('click').bind('click', function (event) {
                event.preventDefault();

                if (manualInstall.find('input[type="file"]').attr('value') == '') {
                    var status = manualInstall.find('.wr-status').removeClass('hide');

                    return setTimeout(function () {
                        status.fadeOut({
                            always: function () {
                                status.addClass('hide').css('display', '');
                            }
                        });
                    }, 1000);
                }

	            // Remove failure message box
	            $('.wr-upload-alert').remove();

                // Submit upload form
                manualInstall.children('form').submit();

                // Hide upload form
                manualInstall.addClass('hide');

                // Toggle button state
                self.install_button.hide();

                // Switch loading status
                upload.removeClass('hide');
            });

            self.install_button.show().children().addClass('hide').filter('.continue').removeClass('hide');

            // Setup handler
            manualInstall.children('iframe').unbind('load').bind('load', function () {
                if (manualInstall.find('input[type="file"]').attr('value') == '') {
                    return;
                }

                // Hide manual install form
                manualInstall.addClass('hide').find('.wr-loading').hide();

                // Parse response data
                var response;

                if (response = $(this).contents().text().match(/\{"status":[^,]+,"data":[^\}]+\}/)) {
                    response = $.parseJSON(response[0]);
                } else {
                    response = {status: 'failure', data: $(this).contents().text()};
                }

                if (response.status == 'success') {
            
                    // Import sample data if install from upload package
                    if( self.install_from_upload_package ) {
                    	
                    	// Switch status
                        upload.find('.wr-loading').removeClass('wr-loading').addClass('wr-icon-ok');

                        // Remove form upload sql
                        manualInstall.remove();

                        // Import sql
                        return self.import();
                    } else {
                        self.download(upload);
                    }
            
                } else {
                    upload.addClass('hide');
                    manualInstall.removeClass('hide');
					self.install_button.show().children().addClass('hide').filter('.continue').removeClass('hide');

                    // Show failure message box
                    $('#wr-install-sample-data-modal .modal-body').prepend( '<div class="wr-status wr-upload-alert alert alert-danger"><div class="wr-status-message">' + response.data + '</div></div>' );
                }
            });
        },
        manualInstallUpload: function () {
            var self = this,
                upload = $('#wr-install-sample-data-upload-asset'),
                manualInstall = $('#wr-install-sample-data-manually-upload');

			// Show manual sample data installation form
			manualInstall.removeClass('hide');

			// Init button to continue manual sample data installation
			self.install_button.unbind('click').bind('click', function(event) {
				event.preventDefault();

				if (manualInstall.find('input[type="file"]').attr('value') == '') {
					var status = manualInstall.find('.wr-status').removeClass('hide');

					return setTimeout(function() {
						status.fadeOut({
							always: function() {
								status.addClass('hide').css('display', '');
							}
						});
					}, 1000);
				}
				
				// Remove failure message box
	            $('.wr-upload-alert').remove();

				// Submit upload form
				manualInstall.children('form').submit();

				// Hide upload form
				manualInstall.addClass('hide');

				// Toggle button state
				self.install_button.hide();

				// Switch loading status
				upload.removeClass('hide');
			});

			self.install_button.show().children().addClass('hide').filter('.continue').removeClass('hide');

			// Setup handler
			manualInstall.children('iframe').unbind('load').bind('load', function() {
				if (manualInstall.find('input[type="file"]').attr('value') == '') {
					return;
				}

				// Hide manual install form
				manualInstall.addClass('hide').find('.wr-loading').hide();

				// Parse response data
				var response;

				if (response = $(this).contents().text().match(/\{"status":[^,]+,"data":[^\}]+\}/)) {
					response = $.parseJSON(response[0]);
				} else {
					response = {status: 'failure', data: $(this).contents().text()};
				}

				if (response.status == 'success') {
					upload.find('.wr-loading').removeClass('wr-loading').addClass('wr-icon-ok');
	                self.finish('success', response.data);
				} else {
					upload.addClass('hide');
                    manualInstall.removeClass('hide');
					self.install_button.show().children().addClass('hide').filter('.continue').removeClass('hide');

                    // Show failure message box
                    $('#wr-install-sample-data-modal .modal-body').prepend( '<div class="wr-status wr-upload-alert alert alert-danger"><div class="wr-status-message">' + response.data + '</div></div>' );
				}
			});
		},

		processPlugins: function(listPlugins) {
			var	self = this,
				requiredPlugins = $('#wr-install-sample-data-required-plugins');

			// Get element containing optional plugins
			self.optionalPlugins = $('#wr-install-sample-data-optional-plugins');

			if (listPlugins.required) {
				// Show list of required plugins
				requiredPlugins.removeClass('hide').html(listPlugins.required);

				// Install required plugins
				self.installPlugins(requiredPlugins);
			}

			if (listPlugins.optional) {
				// Show list of optional plugins
				self.optionalPlugins.html(listPlugins.optional);

				// Setup plugin details toggle
				self.optionalPlugins.find('a.wr-plugin-details-toggle').unbind('click').bind('click', function(event) {
					event.preventDefault();

					if ($(this).children().hasClass('wr-icon-plus')) {
						// Show plugin details then switch toggle icon
						$(this).parent().children('p.wr-plugin-details').removeClass('hide');
						$(this).children().removeClass('wr-icon-plus').addClass('wr-icon-minus');
					} else {
						// Hide plugin details then switch toggle icon
						$(this).parent().children('p.wr-plugin-details').addClass('hide');
						$(this).children().removeClass('wr-icon-minus').addClass('wr-icon-plus');
					}
				});

				// Init button to continue sample data installation
				self.install_button.unbind('click').bind('click', function(event) {
					event.preventDefault();

					// Toggle button state
					self.install_button.hide();

					// Install optional plugins
					self.installPlugins(self.optionalPlugins);
				});

				if (!listPlugins.required) {
					// Show list of optional plugins
					self.optionalPlugins.removeClass('hide');

					// Toogle button state
					self.install_button.show();
				}
			}
		},

		installPlugins: function(listPlugins) {
			var self = this;

			// Hide all unnecessary elements
			listPlugins.find('input, span.label, a.wr-plugin-details-toggle, p.wr-plugin-details').addClass('hide');

			// Find all selected plugins
			self.beingInstalled = [];

			listPlugins.find('input').each(function(i, e) {
				if (e.type == 'hidden' || e.checked) {
					self.beingInstalled.push(e);
				}
			});

			if (self.beingInstalled.length) {
				// Start install selected plugins
				self.installing = 0;
				self.installPlugin();
			} else {
				// Start importing sample data
				self.import();
			}
		},

		installPlugin: function() {
			var	self = this,
				plugin = self.beingInstalled[self.installing].value,
				listPlugin = $(self.beingInstalled[self.installing]).parent().parent();

			// Show loading status
			listPlugin.find('.wr-loading').removeClass('hide');

			// Request server to install plugin
			$.ajax({
				url: self.params.ajax_url + '&task=install-plugin&plugin=' + plugin,
				complete: function(response) {
					// Indicate that plugin installation step is completed
					listPlugin.addClass('wr-complete');

					// Parse response data
					if (response = response.responseText.match(/\{"status":[^,]+,"data":[^\}]+\}/)) {
						response = $.parseJSON(response[0]);
					} else {
						response = {status: 'failure', data: response.responseText};
					}

					if (response.status != 'success') {
						// Switch status
						listPlugin.find('.wr-loading').removeClass('wr-loading').addClass('wr-icon-remove');

						// Show error message
						listPlugin.find('.wr-status').html(response.data).removeClass('hide');
					} else {
						// Switch status
						listPlugin.find('.wr-loading').removeClass('wr-loading').addClass('wr-icon-ok');
					}

					// Increase the number of installed plugin
					self.installing++;

					if (self.installing < self.beingInstalled.length) {
						// Send a request to install next selected plugin
						self.installPlugin();
					} else {
						// Installed all plugins
						listPlugin.parent().parent().addClass('wr-complete').children('i.wr-icon').attr('class', 'wr-icon-ok');

						if (self.optionalPlugins.html() != '' && self.optionalPlugins.hasClass('hide')) {
							// Show list of optional plugins
							self.optionalPlugins.removeClass('hide');

							// Toggle button state
							self.install_button.show();
						} else {
							// Start importing sample data
							self.import();
						}
					}
				}
			});
		},

		import: function() {
			var	self = this,
				element = $('#wr-install-sample-data-import-data');

			// State that sample data is being imported
			element.removeClass('hide');

			// Import sample data
			$.getJSON(
				self.params.ajax_url + '&task=import-data&import=1' + ( self.install_from_upload_package ? '&import_upload=1' : '' ),
				function(response) {
					if (response.status == 'success') {
						// Send a request to permalink settings page to let WordPress re-build permalink structure
						$.ajax({
							url: self.params.base_url + 'options-permalink.php',
							complete: function() {
								// Indicate that import step is completed
								element.addClass('wr-complete');

								// Switch status
								element.find('.wr-loading').removeClass('wr-loading').addClass('wr-icon-ok');

								// Set a flag for reloading theme customizer
								self.reload_theme_customizer = true;

								// Show form confirm upload asset images if install from upload package
								if( self.install_from_upload_package ) { 
									return self.manualInstallUpload();
								}
								
								// Get demo assets
								if (response.data && response.data.indexOf('window.wr_demo_assets') > -1) {
									$(document.body).append($('<div />').hide().html(response.data));

									// Clear demo assets from response
									response.data = response.data.replace(/<script[^>]+>window.wr_demo_assets = [^;]+;<\/script>/, '');
								}

								// Check if we have to download any demo asset?
								if (window.wr_demo_assets) {
									return self.downloadAssets(response.data);
								}

								// Show success message box
								self.finish('success', response.data);
							}
						});
					} else {
						// Indicate that import step is completed
						element.addClass('wr-complete');

						// Switch status
						element.find('.wr-loading').removeClass('wr-loading').addClass('wr-icon-remove');

						// Show failure message box
						self.finish('failure', response.data);
					}
				}
			);
		},

		downloadAssets: function(message) {
			var	self = this,
				element = $('#wr-install-sample-data-demo-assets');

			// Detect current status
			if (typeof self.currentAsset == 'undefined') {
				self.currentAsset = 0;
			} else {
				self.currentAsset++;
			}

			// Calculate completed percentage
			var percent = Math.round(self.currentAsset * 100 / window.wr_demo_assets.length);

			// Update progress bar
			element.find('.progress-bar').css('width', percent + '%').children('.percentage').text(percent);

			// Check if all assets has been downloaded
			if (self.currentAsset >= window.wr_demo_assets.length) {
				// Indicate that download demo assets is completed
				element.addClass('wr-complete');

				// Switch status
				element.find('.wr-loading').removeClass('wr-loading').addClass('wr-icon-ok');

				// Remove download status and progress bar
				element.find('.download-status, .progress').remove();

				// Show success message box
				return self.finish('success', message);
			}

			// State that demo assets is being downloaded
			if (element.hasClass('hide')) {
				element.removeClass('hide');
			}

			// Update download status
			element.find('.download-status').text((self.currentAsset + 1) + '/' + window.wr_demo_assets.length + ': ' + window.wr_demo_assets[self.currentAsset]);

			// Request server to download demo asset
			$.getJSON(
				self.params.ajax_url + '&task=download-asset&asset=' + self.currentAsset,
				function(response) {
					if (response.status == 'success') {
						self.downloadAssets(message);
					} else {
						// Indicate that download demo assets is completed
						element.addClass('wr-complete');

						// Switch status
						element.find('.wr-loading').removeClass('wr-loading').addClass('wr-icon-remove');

						// Remove download status and progress bar
						element.find('.download-status, .progress').remove();

						// Show failure message box
						self.finish('failure', response.data);
					}
				}
			);
		},

		restore: function() {
			var self = this;

			// Init button to restore original data
			self.install_button.unbind('click').bind('click', function(event) {
				event.preventDefault();

				// Get steps
				var	restore_data = $('#wr-restore-original-data-import-data'),
					remove_assets = $('#wr-restore-original-data-demo-assets');

				// Show restoration progress
				self.modal.find('#wr-restore-original-data-confirmation').hide().parent().find('#wr-restore-original-data-progress').removeClass('hide');

				// Toggle button state
				self.install_button.hide();

				// Request server-side script to restore original data
				$.getJSON(
					self.params.ajax_url + '&task=restore-data',
					function(response) {
						// Indicate that restore data step is completed
						restore_data.addClass('wr-complete');

						if (response.status == 'success') {
							// Switch status
							restore_data.find('.wr-loading').removeClass('wr-loading').addClass('wr-icon-ok');

							// State that theme customizer should be reloaded
							self.reload_theme_customizer = true;

							// Request server-side script to remove demo assets
							remove_assets.removeClass('hide');

							$.getJSON(
								self.params.ajax_url + '&task=remove-assets',
								function(response) {
									// Indicate that remove demo assets step is completed
									remove_assets.addClass('wr-complete');

									if (response.status == 'success') {
										// Switch status
										remove_assets.find('.wr-loading').removeClass('wr-loading').addClass('wr-icon-ok');

										// Delete installed plugins
										self.deletePlugins();
									} else {
										// Switch status
										remove_assets.find('.wr-loading').removeClass('wr-loading').addClass('wr-icon-remove');

										// Show failure message box
										self.finish('failure', response.data);
									}
								}
							);
						} else {
							// Switch status
							restore_data.find('.wr-loading').removeClass('wr-loading').addClass('wr-icon-remove');

							// Show failure message box
							self.finish('failure', response.data);
						}
					}
				);
			}).show().children().addClass('hide').filter('.restore').removeClass('hide');
		},

		deletePlugins: function() {
			var self = this;

			if (!$('#wr-restore-original-data-installed-plugins').length) {
				return self.finish('success');
			}

			if (typeof self.deleting == 'undefined') {
				// Set initial state
				self.plugins = $('#wr-restore-original-data-installed-plugins ul li');
				self.deleting = 0;

				// Show delete plugins process
				$('#wr-restore-original-data-installed-plugins').removeClass('hide');
			} else {
				// Increase index
				self.deleting++;
			}

			if (!self.plugins.eq(self.deleting).length) {
				// Indicate that delete plugins step is completed
				$('#wr-restore-original-data-installed-plugins').addClass('wr-complete').find('.wr-icon').attr('class', 'wr-icon-ok');

				return self.finish('success');
			}

			// Show delete plugin process
			self.plugins.eq(self.deleting).removeClass('hide');

			// Request server-side script to delete installed plugins
			$.getJSON(
				self.params.ajax_url + '&task=delete-plugin&plugin=' + self.deleting,
				function(response) {
					// Toggle state
					self.plugins.eq(self.deleting).addClass('wr-complete');

					if (response.status == 'success') {
						// Switch status
						self.plugins.eq(self.deleting).find('.wr-loading').removeClass('wr-loading').addClass('wr-icon-ok');

						// Continue plugin deletion
						self.deletePlugins();
					} else {
						// Switch status
						self.plugins.eq(self.deleting).find('.wr-loading').removeClass('wr-loading').addClass('wr-icon-remove');

						// Show failure message box
						self.finish('failure', response.data);
					}
				}
			);
		},

		finish: function(status, message) {
			// Prepare status
			status = status || 'success';

			if (status != 'success' && status != 'failure') {
				status = 'failure';
			}

			var self = this, element = $('#wr-install-sample-data-' + status + '-message').removeClass('hide');

			// Set success message if any
			if ($.trim(message)) {
				element.find('.wr-status-message').html(message).parent().removeClass('hide');
			}

			// Toggle buttons state
			self.install_button.unbind('click').bind('click', function(event) {
				event.preventDefault();

				// Hide modal
				self.modal.modal('hide');
			}).show().children().addClass('hide').filter('.finish').removeClass('hide');

			self.cancel_button.hide();
		}
	};
})(jQuery);
