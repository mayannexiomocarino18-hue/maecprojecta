import './bootstrap';

(function (window, document) {
    if (!window.jQuery) {
        return;
    }

    function redirectFresh(url) {
        let separator = url.indexOf('?') === -1 ? '?' : '&';
        window.location.replace(url + separator + '_=' + Date.now());
    }

    function showConfirmDialog(options) {
        let $overlay = window.jQuery('#confirmOverlay');

        if (! $overlay.length) {
            window.jQuery('body').append(
                '<div class="confirm-overlay" id="confirmOverlay" aria-hidden="true">' +
                    '<div class="confirm-dialog">' +
                        '<div class="confirm-eyebrow" id="confirmEyebrow">Please Confirm</div>' +
                        '<div class="confirm-title" id="confirmTitle">Confirm Action</div>' +
                        '<div class="confirm-message" id="confirmMessage">Are you sure you want to continue?</div>' +
                        '<div class="confirm-actions">' +
                            '<button type="button" class="btn btn-confirm-cancel" id="confirmCancelBtn">Cancel</button>' +
                            '<button type="button" class="btn btn-confirm-danger" id="confirmOkBtn">Continue</button>' +
                        '</div>' +
                    '</div>' +
                '</div>'
            );
            $overlay = window.jQuery('#confirmOverlay');
        }

        let $eyebrow = window.jQuery('#confirmEyebrow');
        let $title = window.jQuery('#confirmTitle');
        let $message = window.jQuery('#confirmMessage');
        let $cancel = window.jQuery('#confirmCancelBtn');
        let $ok = window.jQuery('#confirmOkBtn');

        $eyebrow.text(options.eyebrow || 'Please Confirm');
        $title.text(options.title || 'Confirm Action');
        $message.text(options.message || 'Are you sure you want to continue?');
        $ok.text(options.confirmLabel || 'Continue');
        $overlay.addClass('is-visible').attr('aria-hidden', 'false');

        function closeDialog() {
            $overlay.removeClass('is-visible').attr('aria-hidden', 'true');
            $cancel.off('click.confirmDialog');
            $ok.off('click.confirmDialog');
            $overlay.off('click.confirmDialog');
            window.jQuery(document).off('keydown.confirmDialog');
        }

        $cancel.on('click.confirmDialog', function () {
            closeDialog();
        });

        $ok.on('click.confirmDialog', function () {
            closeDialog();
            options.onConfirm();
        });

        $overlay.on('click.confirmDialog', function (event) {
            if (event.target === this) {
                closeDialog();
            }
        });

        window.jQuery(document).on('keydown.confirmDialog', function (event) {
            if (event.key === 'Escape') {
                closeDialog();
            }
        });
    }

    function resetErrors(panelSelector, errorBoxSelector) {
        window.jQuery(panelSelector).find('.field-error').removeClass('field-error');
        window.jQuery(panelSelector).find('[data-error-for]').text('');
        window.jQuery(errorBoxSelector).addClass('d-none').html('');
    }

    function showErrors(panelSelector, errorBoxSelector, xhr) {
        let response = xhr.responseJSON || {};
        let errors = response.errors || {};
        let lines = [];

        window.jQuery.each(errors, function (field, messages) {
            window.jQuery(panelSelector).find('[data-error-for="' + field + '"]').text(messages[0] || '');
            lines.push(messages[0] || '');
        });

        if (!lines.length && response.message) {
            lines.push(response.message);
        }

        if (lines.length) {
            if (window.jQuery(errorBoxSelector).length) {
                window.jQuery(errorBoxSelector).removeClass('d-none').html(lines.join('<br>'));
            } else {
                window.alert(lines.join('\n'));
            }
        }
    }

    function loadStudents() {
        let target = window.jQuery('#students_list');

        if (!target.length) {
            return;
        }

        let url = target.data('load-url');

        if (!url) {
            return;
        }

        window.jQuery.get(url, function (data) {
            target.html(data);
        });
    }

    function loadTeachers() {
        let target = window.jQuery('#teachers_list');

        if (!target.length) {
            return;
        }

        let url = target.data('load-url');

        if (!url) {
            return;
        }

        window.jQuery.get(url, function (data) {
            target.html(data);
        });
    }

    function loadDegrees() {
        let target = window.jQuery('#degrees_list');

        if (!target.length) {
            return;
        }

        let url = target.data('load-url');

        if (!url) {
            return;
        }

        window.jQuery.get(url, function (data) {
            target.html(data);
        });
    }

    function startAutoLoad() {
        if (window.jQuery('#students_list').length) {
            loadStudents();
            setInterval(function () {
                loadStudents();
            }, 3000);
        }

        if (window.jQuery('#teachers_list').length) {
            loadTeachers();
            setInterval(function () {
                loadTeachers();
            }, 3000);
        }

        if (window.jQuery('#degrees_list').length) {
            loadDegrees();
            setInterval(function () {
                loadDegrees();
            }, 3000);
        }
    }

    window.jQuery(document).ready(function () {
        window.jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': window.jQuery('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        startAutoLoad();

        window.jQuery('#student-create-panel').on('submit', function (event) {
            if (window.jQuery(this).data('normal-submit')) {
                return;
            }

            event.preventDefault();

            let first_name = window.jQuery('#student_first_name').val();
            let last_name = window.jQuery('#student_last_name').val();
            let age = window.jQuery('#student_age').val();
            let address = window.jQuery('#student_address').val();
            let contact_number = window.jQuery('#student_contact_number').val();
            let email = window.jQuery('#student_email').val();
            let username = window.jQuery('#student_username').val();
            let password = window.jQuery('#student_password').val();
            let degree_id = window.jQuery('#student_degree_id').val();
            let panel = '#student-create-panel';
            let errorBox = '#student-create-errors';
            let storeUrl = window.jQuery(panel).data('store-url');
            let redirectUrl = window.jQuery(panel).data('redirect-url');

            resetErrors(panel, errorBox);
            window.jQuery('#saveStudent').prop('disabled', true);

            window.jQuery.ajax({
                url: storeUrl,
                type: 'POST',
                data: {
                    first_name: first_name,
                    last_name: last_name,
                    age: age,
                    address: address,
                    contact_number: contact_number,
                    email: email,
                    username: username,
                    password: password,
                    degree_id: degree_id
                },
                success: function () {
                    redirectFresh(redirectUrl);
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        showErrors(panel, errorBox, xhr);
                    } else {
                        let message = 'Something went wrong. Please try again.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        if (window.jQuery(errorBox).length) {
                            window.jQuery(errorBox).removeClass('d-none').text(message);
                        } else {
                            window.alert(message);
                        }
                    }
                },
                complete: function () {
                    window.jQuery('#saveStudent').prop('disabled', false);
                }
            });
        });

        window.jQuery('#student-edit-panel').on('submit', function (event) {
            event.preventDefault();

            let id = window.jQuery('#student_id').val();
            let first_name = window.jQuery('#student_edit_first_name').val();
            let last_name = window.jQuery('#student_edit_last_name').val();
            let age = window.jQuery('#student_edit_age').val();
            let address = window.jQuery('#student_edit_address').val();
            let contact_number = window.jQuery('#student_edit_contact_number').val();
            let email = window.jQuery('#student_edit_email').val();
            let degree_id = window.jQuery('#student_edit_degree_id').val();
            let panel = '#student-edit-panel';
            let errorBox = '#student-edit-errors';
            let updateUrl = window.jQuery(panel).data('update-url');
            let redirectUrl = window.jQuery(panel).data('redirect-url');

            resetErrors(panel, errorBox);
            window.jQuery('#updateStudentBtn').prop('disabled', true);

            window.jQuery.ajax({
                url: updateUrl || ('/students/' + id),
                type: 'PUT',
                data: {
                    first_name: first_name,
                    last_name: last_name,
                    age: age,
                    address: address,
                    contact_number: contact_number,
                    email: email,
                    degree_id: degree_id
                },
                success: function () {
                    redirectFresh(redirectUrl);
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        showErrors(panel, errorBox, xhr);
                    } else {
                        let message = 'Something went wrong. Please try again.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        if (window.jQuery(errorBox).length) {
                            window.jQuery(errorBox).removeClass('d-none').text(message);
                        } else {
                            window.alert(message);
                        }
                    }
                },
                complete: function () {
                    window.jQuery('#updateStudentBtn').prop('disabled', false);
                }
            });
        });

        window.jQuery('#teacher-create-panel').on('submit', function (event) {
            event.preventDefault();

            let username = window.jQuery('#teacher_username').val();
            let email = window.jQuery('#teacher_email').val();
            let password = window.jQuery('#teacher_password').val();
            let panel = '#teacher-create-panel';
            let errorBox = '#teacher-create-errors';
            let storeUrl = window.jQuery(panel).data('store-url');
            let redirectUrl = window.jQuery(panel).data('redirect-url');

            resetErrors(panel, errorBox);
            window.jQuery('#saveTeacher').prop('disabled', true);

            window.jQuery.ajax({
                url: storeUrl,
                type: 'POST',
                data: {
                    username: username,
                    email: email,
                    password: password
                },
                success: function () {
                    redirectFresh(redirectUrl);
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        showErrors(panel, errorBox, xhr);
                    } else {
                        let message = 'Something went wrong. Please try again.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        if (window.jQuery(errorBox).length) {
                            window.jQuery(errorBox).removeClass('d-none').text(message);
                        } else {
                            window.alert(message);
                        }
                    }
                },
                complete: function () {
                    window.jQuery('#saveTeacher').prop('disabled', false);
                }
            });
        });

        window.jQuery('#degree-create-panel').on('submit', function (event) {
            event.preventDefault();

            let title = window.jQuery('#degree_title').val();
            let panel = '#degree-create-panel';
            let errorBox = '#degree-create-errors';
            let storeUrl = window.jQuery(panel).data('store-url');
            let redirectUrl = window.jQuery(panel).data('redirect-url');

            resetErrors(panel, errorBox);
            window.jQuery('#saveDegree').prop('disabled', true);

            window.jQuery.ajax({
                url: storeUrl,
                type: 'POST',
                data: {
                    title: title
                },
                success: function () {
                    redirectFresh(redirectUrl);
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        showErrors(panel, errorBox, xhr);
                    } else {
                        let message = 'Something went wrong. Please try again.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        if (window.jQuery(errorBox).length) {
                            window.jQuery(errorBox).removeClass('d-none').text(message);
                        } else {
                            window.alert(message);
                        }
                    }
                },
                complete: function () {
                    window.jQuery('#saveDegree').prop('disabled', false);
                }
            });
        });

        window.jQuery('#degree-edit-panel').on('submit', function (event) {
            event.preventDefault();

            let id = window.jQuery('#degree_id').val();
            let title = window.jQuery('#degree_edit_title').val();
            let panel = '#degree-edit-panel';
            let errorBox = '#degree-edit-errors';
            let updateUrl = window.jQuery(panel).data('update-url');
            let redirectUrl = window.jQuery(panel).data('redirect-url');

            resetErrors(panel, errorBox);
            window.jQuery('#updateDegreeBtn').prop('disabled', true);

            window.jQuery.ajax({
                url: updateUrl || ('/degrees/' + id),
                type: 'PUT',
                data: {
                    title: title
                },
                success: function (response) {
                    window.alert('Degree updated successfully!');
                    redirectFresh(redirectUrl);
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        showErrors(panel, errorBox, xhr);
                    } else {
                        let message = 'Something went wrong. Please try again.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        if (window.jQuery(errorBox).length) {
                            window.jQuery(errorBox).removeClass('d-none').text(message);
                        } else {
                            window.alert(message);
                        }
                    }
                },
                complete: function () {
                    window.jQuery('#updateDegreeBtn').prop('disabled', false);
                }
            });
        });

        window.jQuery(document).on('click', '.delete-student-btn', function () {
            deleteStudent(window.jQuery(this).data('delete-url'), window.jQuery(this).data('redirect-url'));
        });

        window.jQuery(document).on('click', '.delete-degree-btn', function () {
            deleteDegree(window.jQuery(this).data('delete-url'), window.jQuery(this).data('redirect-url'));
        });
    });

    function deleteStudent(deleteUrl, redirectUrl) {
        showConfirmDialog({
            eyebrow: 'Delete Student',
            title: 'Remove This Student?',
            message: 'This will permanently remove the student from the list. Continue?',
            confirmLabel: 'Delete Student',
            onConfirm: function () {
                window.jQuery.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    success: function () {
                        redirectFresh(redirectUrl);
                    },
                    error: function (xhr) {
                        let message = 'Something went wrong. Please try again.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        window.alert(message);
                    }
                });
            }
        });
    }

    function deleteTeacher(deleteUrl, redirectUrl) {
        if (window.confirm('Delete this teacher?')) {
            window.jQuery.ajax({
                url: deleteUrl,
                type: 'DELETE',
                success: function (response) {
                    window.alert('Teacher deleted successfully!');
                    redirectFresh(redirectUrl);
                },
                error: function (xhr) {
                    let message = 'Something went wrong. Please try again.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    window.alert(message);
                }
            });
        }
    }

    function deleteDegree(deleteUrl, redirectUrl) {
        showConfirmDialog({
            eyebrow: 'Delete Degree',
            title: 'Remove This Degree?',
            message: 'This will delete the degree if it is no longer in use. Continue?',
            confirmLabel: 'Delete Degree',
            onConfirm: function () {
                window.jQuery.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    success: function () {
                        redirectFresh(redirectUrl);
                    },
                    error: function (xhr) {
                        let message = 'Something went wrong. Please try again.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        window.alert(message);
                    }
                });
            }
        });
    }

    window.deleteStudent = deleteStudent;
    window.deleteTeacher = deleteTeacher;
    window.deleteDegree = deleteDegree;
})(window, document);
