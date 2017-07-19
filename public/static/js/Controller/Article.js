function Article() {
    this.init = function() {
        //
    }

    this.show = function() {
        var self = this;

        $('#delete-item').on('click', function(e) {
            e.preventDefault();
            var itemId = $(e.target).data('id');
            $(e.target).attr('disabled', true);

            $("#delete-modal").modal('show');

            $('#delete-modal').find('button.delete-btn').off('click').on('click', function (ev) {
                ev.preventDefault();
                self._delete(itemId);
            });

            $('#delete-modal').find('button.close-btn').off('click').on('click', function (ev) {
                ev.preventDefault();
                $(e.target).attr('disabled', false);
                $("#delete-modal").modal('hide');
            });
        });
    }

    this.create = function() {
        $('#text').summernote({
            lang: 'de-DE',
            height: '150px',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['link', ['linkDialogShow', 'unlink']],
                ['misc', ['fullscreen', 'codeview', 'undo', 'redo', 'reset']]
            ],
            callbacks: {
                onImageUpload: function(files) {
                    return false;
                }
            }
        });

        $('form').on('submit', function(e) {
            e.preventDefault();

            $('button.close').closest('.alert').detach().remove();
            $(e.target).find('input[type=submit]').attr('disabled', true);

            var params = {
                Title: $('#title').val(),
                Text: $('#text').val()
            };

            // TODO: implement validation before send data to server

            $.postJSON('/api/articles', params, function(res) {
                if (res.Status == 1) {
                    var successBlock = ''
                        + '<div class="alert alert-success alert-dismissible" role="alert">'
                        + '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        + '        <span aria-hidden="true">&times;</span>'
                        + '    </button>'
                        + '    <strong>Well done!</strong> You successfully inserted article'
                        + '</div>';
                    $('#content .wrapper').prepend(successBlock);
                    setTimeout(function () {
                        window.location.href = '/articles/' + res.ArticleId;
                    }, 2000);
                } else {
                    $(e.target).find('input[type=submit]').attr('disabled', false);
                    var errorBlock = ''
                        + '<div class="alert alert-danger alert-dismissible" role="alert">'
                        + '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        + '        <span aria-hidden="true">&times;</span>'
                        + '    </button>'
                        + '    <strong>Oh snap!</strong> Change a few things up and try submitting again'
                        + '</div>';
                    $('#content .wrapper').prepend(errorBlock);
                }
            });
        });
    }

    this.update = function() {
        $('#text').summernote({
            lang: 'de-DE',
            height: '150px',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['link', ['linkDialogShow', 'unlink']],
                ['misc', ['fullscreen', 'codeview', 'undo', 'redo', 'reset']]
            ],
            callbacks: {
                onImageUpload: function(files) {
                    return false;
                }
            }
        });

        $('form').on('submit', function(e) {
            e.preventDefault();

            $('button.close').closest('.alert').detach().remove();
            $(e.target).find('input[type=submit]').attr('disabled', true);

            var itemId = $(e.target).data('id');
            var params = {
                Title: $('#title').val(),
                Text: $('#text').val()
            };

            // TODO: implement validation before send data to server

            $.postJSON('/api/articles/' + itemId, params, function(res) {
                if (res.Status == 1) {
                    var successBlock = ''
                        + '<div class="alert alert-success alert-dismissible" role="alert">'
                        + '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        + '        <span aria-hidden="true">&times;</span>'
                        + '    </button>'
                        + '    <strong>Well done!</strong> You successfully updated this book'
                        + '</div>';
                    $('#content .wrapper').prepend(successBlock);
                    setTimeout(function () {
                        window.location.href = '/articles/' + res.Article.Id;
                    }, 2000);
                } else {
                    $(e.target).find('input[type=submit]').attr('disabled', false);
                    var errorBlock = ''
                        + '<div class="alert alert-danger alert-dismissible" role="alert">'
                        + '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                        + '        <span aria-hidden="true">&times;</span>'
                        + '    </button>'
                        + '    <strong>Oh snap!</strong> Change a few things up and try submitting again'
                        + '</div>';
                    $('#content .wrapper').prepend(errorBlock);
                }
            });
        });
    }

    this._delete = function(itemId) {
        $.deleteJSON('/api/articles/' + itemId, [], function(res) {
            if (res.Status == 1) {
                var successBlock = ''
                    + '<div class="alert alert-success alert-dismissible" role="alert">'
                    + '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                    + '        <span aria-hidden="true">&times;</span>'
                    + '    </button>'
                    + '    <strong>Well done!</strong> You successfully deleted this book'
                    + '</div>';
                $('#content .wrapper').prepend(successBlock);
                $("#delete-modal").modal('hide');
                setTimeout(function () {
                    window.location.href = '/articles';
                }, 2000);
            } else {
                $(e.target).attr('disabled', false);
                var errorBlock = ''
                    + '<div class="alert alert-danger alert-dismissible" role="alert">'
                    + '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                    + '        <span aria-hidden="true">&times;</span>'
                    + '    </button>'
                    + '    <strong>Oh snap!</strong> Change a few things up and try submitting again'
                    + '</div>';
                $("#delete-modal").modal('hide');
                $('#content .wrapper').prepend(errorBlock);
            }
        });
    }
}
