const easybsmodalsutils = {

    showGeneric: function(modal, title, text, close_text, reload_on_close) {

        easybsmodals.reset(modal);

        easybsmodals.setTitle(modal, title);
        easybsmodals.setText(modal, text);

        easybsmodals.addDismissButton(modal, close_text);

        $(modal).modal('show');

        if (reload_on_close) {
            $(modal).on('hidden.bs.modal', function (e) {
                location.reload();
            });
        }
    },

    addGenericFormSubmitConfirm: function(form_id, _on_submit_callback = null) {

        const modal = easybsmodals.create('generic-form-submit-modal');
        const form = document.getElementById(form_id);

        form.addEventListener('submit', function(e) {

            e.preventDefault();

            easybsmodals.reset(modal);

            easybsmodals.setTitle(modal, generic_confirm_modal_title);
            easybsmodals.setText(modal, generic_confirm_modal_text);

            easybsmodals.addDismissButton(modal, generic_confirm_modal_cancel);

            easybsmodals.addButton(modal, 'confirm_btn', 'btn-success', generic_confirm_modal_confirm, function() {

                if (_on_submit_callback !== null)
                    _on_submit_callback();

                form.submit();
            });

            $(modal).modal('show');
        });
    },

};