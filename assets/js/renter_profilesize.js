 (function (factory) {
        'use strict';
        if (typeof define === 'function' && define.amd) {
            // Register as an anonymous AMD module:
            define([
                'jquery',
                './jquery.fileupload-process'
            ], factory);
        } else if (typeof exports === 'object') {
            // Node/CommonJS:
            factory(require('jquery'));
        } else {
            // Browser globals:
            factory(
                window.jQuery
            );
        }
    }(function ($) {
        'use strict';

        // Append to the default processQueue:
        $.blueimp.fileupload.prototype.options.processQueue.push(
            {
                action: 'validateTotalSize',
                // Always trigger this action,
                // even if the previous action was rejected: 
                always: true,
                // Options taken from the global options map:
                maxSizeOfFiles: '@',
            }
        );

        $.widget('blueimp.fileupload', $.blueimp.fileupload, {

            options: {
                /*
                // The maximum allowed size of all files combined in bytes:
                maxSizeOfFiles: 10000000, // 10 MB
                */

                // Function returning the current size of files,
                // has to be overriden for maxSizeOfFiles validation:
                getSizeOfFiles: $.noop,

                // Error and info messages:
                messages: {
                    maxSizeOfFiles: 'Maximum size of all files exceeded',
                }
            },

            processActions: {

                validateTotalSize: function (data, options) {
                    var $this = $(this),
                        that = $this.data('blueimp-fileupload') ||
                            $this.data('fileupload');

                    if (options.disabled) {
                        return data;
                    }

                    var dfd = $.Deferred(),
                        settings = this.options,
                        file = data.files[data.index];

                    console.log(settings.getSizeOfFiles());
                    if (settings.getSizeOfFiles() > options.maxSizeOfFiles) {
                        file.error = settings.i18n('maxSizeOfFiles');
                    }
                    //else {
                    //    delete file.error;
                    //}

                    if (file.error || data.files.error) {
                        data.files.error = true;
                        dfd.rejectWith(this, [data]);
                    } else {
                        dfd.resolveWith(this, [data]);
                    }

                    return dfd.promise();
                }
            }
        });

        $(document).ready(function () {
            var totalSize = 0;

            $('.profImage').fileupload({
                autoUpload: false,
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                dataType: 'json',
                maxFileSize: 2000000, // 2 MB
                maxSizeOfFiles: 10000000, // 10 MB
                getSizeOfFiles: function () {
                    return totalSize;
                },
            });

            $('.profImage').bind('fileuploadadd', function (e, data) {
                $.each(data.files, function (index, file) {
                    console.log('Adding file: ' + file.name + ', ' + file.size);
                    totalSize = totalSize + file.size;
                    console.log('Total size: ' + totalSize);
                });
            });

            $('.profImage').bind('fileuploadfailed', function (e, data) {
                $.each(data.files, function (index, file) {
                    console.log('Removed file: ' + file.name + ', ' + file.size);
                    totalSize = totalSize - file.size;
                    console.log('Total size: ' + totalSize);
                });
            });
        });
    }));