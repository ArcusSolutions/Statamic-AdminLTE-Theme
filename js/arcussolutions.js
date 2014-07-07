(function($) {
    "use strict";

    $('input[type="checkbox"]#check-all').on('ifUnchecked', function() {
        var dataClass = $(this).attr('data-check-class');
        $('input[type="checkbox"].' + dataClass).iCheck('uncheck');
    }).on('ifChecked', function() {
        var dataClass = $(this).attr('data-check-class');
        $('input[type="checkbox"].' + dataClass).iCheck('check');
    });

    /////////////////////////////////////////
    //
    // Tooltips
    //
    /////////////////////////////////////////

    $('.tip').tooltip();



    /////////////////////////////////////////
    //
    // Mark It Up
    //
    /////////////////////////////////////////

    var languageMarkup;

    switch (content_type.toLowerCase()) {
        case 'md':
        case 'markdown':
            languageMarkup = [
                {name:'Heading 1', openWith:'# ', placeHolder:'Your title here...' },
                {name:'Heading 2', openWith:'## ', placeHolder:'Your title here...' },
                {name:'Heading 3', openWith:'### ', placeHolder:'Your title here...' },
                {name:'Heading 4', openWith:'#### ', placeHolder:'Your title here...' },
                {name:'Heading 5', openWith:'##### ', placeHolder:'Your title here...' },
                {name:'Heading 6', openWith:'###### ', placeHolder:'Your title here...' },
                {name:'Bold', key:'B', openWith:'**', closeWith:'**'},
                {name:'Italic', key:'I', openWith:'_', closeWith:'_'},
                {name:'Bulleted List', openWith:'- ' },
                {name:'Numeric List', openWith:function(markItUp) {
                    return markItUp.line+'. ';
                }},
                {name:'Picture', key:'P', beforeInsert: function(markItUp) {
                    markItUploader.show(markItUp, 'image', 'markdown');
                }},
                {name:'File', beforeInsert: function(markItUp) {
                    markItUploader.show(markItUp, 'file', 'markdown');
                }},
                {name:'Link', key:'L', openWith:'[', closeWith:']([![Url:!:http://]!])', placeHolder:'Your text to link' +
                    ' here...' },
                {name:'Quotes', openWith:'> '},
                {name:'Code Block / Code', openWith:'(!(\t|!|`)!)', closeWith:'(!(`)!)'}
            ];
            break;

        case 'textile':
            languageMarkup = [
                {name:'Heading 1', openWith:'h1. ', placeHolder:'Your title here...' },
                {name:'Heading 2', openWith:'h2. ', placeHolder:'Your title here...' },
                {name:'Heading 3', openWith:'h3. ', placeHolder:'Your title here...' },
                {name:'Heading 4', openWith:'h4. ', placeHolder:'Your title here...' },
                {name:'Heading 5', openWith:'h5. ', placeHolder:'Your title here...' },
                {name:'Heading 6', openWith:'h6. ', placeHolder:'Your title here...' },
                {name:'Bold', key:'B', openWith:'*', closeWith:'*'},
                {name:'Italic', key:'I', openWith:'_', closeWith:'_'},
                {name:'Bulleted List', openWith:'(!(* |!|*)!)'},
                {name:'Numeric List', openWith:'(!(# |!|#)!)'},
                {name:'Picture', key:'P', beforeInsert: function(markItUp) {
                    markItUploader.show(markItUp, 'image', 'textile');
                }},
                {name:'File', beforeInsert: function(markItUp) {
                    markItUploader.show(markItUp, 'file', 'textile');
                }},
                {name:'Link', key:'L', openWith:'"', closeWith:'([![Title]!])":[![Link:!:http://]!]', placeHolder:'Your text to link here...' },
                {name:'Quotes', openWith:'bq. '},
                {name:'Code Block / Code', openWith:'bc. '}
            ];
            break;

        default:
            languageMarkup = [
                {name:'Heading 1', openWith:'<h1>', closeWith:'</h1>', placeHolder:'Your title here...' },
                {name:'Heading 2', openWith:'<h2>', closeWith:'</h2>', placeHolder:'Your title here...' },
                {name:'Heading 3', openWith:'<h3>', closeWith:'</h3>', placeHolder:'Your title here...' },
                {name:'Heading 4', openWith:'<h4>', closeWith:'</h4>', placeHolder:'Your title here...' },
                {name:'Heading 5', openWith:'<h5>', closeWith:'</h5>', placeHolder:'Your title here...' },
                {name:'Heading 6', openWith:'<h6>', closeWith:'</h6>', placeHolder:'Your title here...' },
                {name:'Bold', key:'B', openWith:'<strong>', closeWith:'</strong>'},
                {name:'Italic', key:'I', openWith:'<em>', closeWith:'</em>'},
                {name:'Bulleted List', openWith:'<ul>\n\t<li>', closeWith: '</li>\n</ul>' },
                {name:'Numeric List', openWith:'<ol>\n\t<li>', closeWith: '</li>\n</ol>' },
                {name:'Picture', key:'P', beforeInsert: function(markItUp) {
                    markItUploader.show(markItUp, 'image', 'html');
                }},
                {name:'File', beforeInsert: function(markItUp) {
                    markItUploader.show(markItUp, 'file', 'html');
                }},
                {name:'Link', key:'L', openWith:'<a href="[![Link:!:http://]!]"(!( title="[![Title]!]")!)>', closeWith:'</a>', placeHolder:'Your text to link...' },
                {name:'Quotes', openWith:'<blockquote>\n\t<p>', closeWith:'\n</p></blockquote>'},
                {name:'Code Block / Code', openWith:'<pre><code>', closeWith:'</code></pre>'},
            ];
            break;
    }

    var markItUploader = {
        modal: $('#markituploader'),
        show: function(markItUp, uploadType, lang) {
            var self = this;
            self.lang = lang;
            self.uploadType = uploadType;
            // one-time setup
            if ( ! self.modal.hasClass('initialized')) {
                self.init(markItUp, uploadType, lang);
            }
            // reset
            self.reset();
            // show modal
            self.modal.modal();
            // bind the insert button
            self.bindInsert();
            // add the alt text
            self.modal.find('.alt-text').val(markItUp.selection);
            // adjust the label
            self.modal.find('.alt-label').toggle(uploadType == 'image');
        },
        init: function(markItUp, uploadType, lang) {
            var self = this;
            self.dropzone = $('#miu-dropzone');
            // bind uploader to field
            $('#miu-file').fileupload({
                dataType: 'json',
                url: markItUp.textarea.dataset[uploadType+'Url'],
                dropzone: self.dropzone,
                replaceFileInput: false, // prevent 'no file chosen' when a file is chosen
                done: function (e, data) {
                    self.uploadComplete(data);
                }
            });
            // dropzone effects
            self.bindDropzoneEffects();
            // mark
            self.modal.addClass('initialized');
        },
        reset: function() {
            var self = this;
            self.img = undefined;
            self.dropzone.removeClass('done');
            self.dropzone.find('.ss-icon').text('attach');
            self.dropzone.find('b').text('Drag a file here to upload it');
        },
        uploadComplete: function(data) {
            var self = this;
            self.img = data.result.filelink;
            self.dropzone.addClass('done');
            self.dropzone.find('.ss-icon').text('image');
            self.dropzone.find('b').text(self.img);
        },
        bindInsert: function() {
            var self = this;
            self.modalFooter = self.modal.find('.modal-footer');
            self.modalFooter.find('button').one('click', function(e) {
                e.preventDefault();
                self.alt = self.modal.find('.alt-text').val();
                self.replace();
                self.modal.modal('hide');
            });
        },
        replace: function() {
            var alt = this.alt || '';
            var url = this.img;

            if (self.uploadType == 'image') {

                if (this.lang === 'markdown') {
                    var str = '!['+alt+']('+url+')';
                } else if (this.lang === 'textile') {
                    alt = (alt) ? '['+alt+']' : '';
                    var str = '!'+url+alt+'!';
                } else { // html
                    var str = '<img src="'+url+'" alt="'+alt+'" />';
                }

            } else {

                var text = alt;
                if (this.lang === 'markdown') {
                    var str = '['+text+']('+url+')';
                } else if (this.lang === 'textile') {
                    var str = '"'+text+'":'+url;
                } else { // html
                    var str = '<a href="'+url+'">'+text+'</a>';
                }

            }
            $.markItUp({ replaceWith: str });
        },
        bindDropzoneEffects: function() {
            var self = this;

            // if drag and drop is available
            if('draggable' in document.createElement('span')) {
                self.modal.addClass('draggable');
                $(document).on('dragover', function (e) {
                    var dropZone = self.dropzone,
                        timeout = window.dropZoneTimeout;
                    if (!timeout) {
                        dropZone.addClass('in');
                    } else {
                        clearTimeout(timeout);
                    }
                    var found = false,
                        node = e.target;
                    do {
                        if (node === dropZone[0]) {
                            found = true;
                            break;
                        }
                        node = node.parentNode;
                    } while (node != null);
                    if (found) {
                        dropZone.addClass('hover');
                    } else {
                        dropZone.removeClass('hover');
                    }
                    window.dropZoneTimeout = setTimeout(function () {
                        window.dropZoneTimeout = null;
                        dropZone.removeClass('in hover');
                    }, 100);
                });
            }
        }
    };

    var markitupSettings = {
        previewParserPath: '',
        onShiftEnter:      {keepDefault:false, openWith:'\n\n'},
        markupSet:         languageMarkup
    };

    $('.markitup').markItUp(markitupSettings);

    $('body').on('addRow', '.grid', function() {
        $('.grid .markitup').not('.markItUpEditor').markItUp(markitupSettings);
    });


    /////////////////////////////////////////
    //
    // File
    //
    /////////////////////////////////////////

    $('.btn-remove-file').on('click', function(e) {
        e.preventDefault();
        var name = $(this).next('input').attr('name');

        $(this).parent().parent().append(
            $('<p />').append($('<input/>').attr('type', 'file').attr('name', name))
        );

        $(this).parent().remove();
    });


    /////////////////////////////////////////
    //
    // Datepicker
    //
    /////////////////////////////////////////

    var dateOptions = {
        format: 'yyyy-mm-dd'
    };

    $('.datepicker').datepicker(dateOptions)
        .on('changeDate', function() {
            $(this).datepicker('hide');
        });

    $('body').on('addRow', '.grid', function() {
        $('.grid .datepicker').datepicker(dateOptions)
            .on('changeDate', function() {
                $(this).datepicker('hide');
            });
    });


    /////////////////////////////////////////
    //
    // Timepicker
    //
    /////////////////////////////////////////


    var timeOptions = { defaultTime: 'value' };

    $('.timepicker').timepicker(timeOptions);

    $('body').on('addRow', '.grid', function() {
        $('.grid .timepicker').timepicker(timeOptions);
    });


    /////////////////////////////////////////
    //
    // Auto Slugger
    //
    /////////////////////////////////////////

    $(document).ready(function() {
        var $slug = $('#publish-slug.new-slug'),
            $title = $('#publish-title');

        if ($slug.length) {
            // the slug field is on this page
            // slug does not already exist in the system
            $title
                .on('keyup', function() {
                    var options = { "lang": $("html").attr("lang") };

                    // if the last move was to erase the title, restart auto-slugging
                    if ($(this).val() === '') {
                        $(this).data('slug-edited', false);
                    }

                    // if someone's manually edited the slug, don't auto-slug
                    if ($(this).data('slug-edited')) {
                        return true;
                    }

                    if (transliterate) {
                        options.custom = transliterate;
                    }

                    $slug.val(getSlug($(this).val(), options));
                });

            $slug
                .on('keyup', function() {
                    // if someone edits the slug manually, don't allow title to auto-slug
                    $title.data('slug-edited', true);
                })
        }
    });


    /////////////////////////////////////////
    //
    // Tags
    //
    /////////////////////////////////////////


    $('.selectize').selectize({
        delimiter: ',',
        persist: false,
        create: function(input) {
            return {
                value: input,
                text: input
            }
        }
    });

})(jQuery);