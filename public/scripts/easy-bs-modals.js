const easybsmodals = {
    
    create: function(modal_id) {

        const modal = document.createElement('div');
        modal.id = modal_id;
        modal.classList.add('modal', 'fade');
        modal.setAttribute('role', 'dialog');
        modal.setAttribute('tabindex', "-1");

        const modal_dialog = document.createElement('div');
        modal_dialog.classList.add('modal-dialog');
        modal_dialog.setAttribute('role', 'document');
        modal.appendChild(modal_dialog);

        const modal_content = document.createElement('div');
        modal_content.classList.add('modal-content');
        modal_dialog.appendChild(modal_content);

        const modal_header = document.createElement('div');
        modal_header.classList.add('modal-header');
        modal_content.appendChild(modal_header);

        const modal_body = document.createElement('div');
        modal_body.classList.add('modal-body');
        modal_content.appendChild(modal_body);

        const modal_footer = document.createElement('div');
        modal_footer.classList.add('modal-footer');
        modal_content.appendChild(modal_footer);

        document.body.appendChild(modal);
        return modal;

    },

    setTitle: function(modal, title) {
        
        const modal_header = modal.children['0'].children['0'].children['0'];
        modal_header.innerHTML = '';

        const modal_title = document.createElement('h4');
        modal_title.classList.add('modal-title');
        modal_header.appendChild(modal_title);
        modal_title.innerHTML = title;

        const modal_close_button = document.createElement('button');
        modal_close_button.setAttribute('type', 'button');
        modal_close_button.classList.add('close');
        modal_close_button.setAttribute('data-dismiss', 'modal');
        modal_close_button.setAttribute('aria-label', 'Close');
        modal_header.appendChild(modal_close_button);
        
        const modal_close_span = document.createElement('span');
        modal_close_span.setAttribute('aria-hidden', 'true');
        modal_close_span.innerHTML = "&times";
        modal_close_button.appendChild(modal_close_span);

    },

    setText: function(modal, text) {

        const modal_body = modal.children['0'].children['0'].children['1'];
        modal_body.innerHTML = '';

        const modal_text = document.createElement('p');
        modal_text.innerHTML = text;
        modal_body.appendChild(modal_text);

    },

    addButton: function(modal, btn_id, btn_class, btn_text, btn_click_fn) {

        const modal_footer = modal.children['0'].children['0'].children['2'];

        const modal_btn = document.createElement('button');
        modal_btn.id = btn_id;
        modal_btn.classList.add('btn', btn_class);
        modal_btn.innerHTML = btn_text;

        if (btn_click_fn !== null) {
            modal_btn.addEventListener('click', btn_click_fn);
        }

        modal_footer.appendChild(modal_btn);

        return modal_btn;

    },

    addDismissButton: function(modal, btn_text) {

        const modal_footer = modal.children['0'].children['0'].children['2'];

        const modal_btn = document.createElement('button');
        modal_btn.classList.add('btn', 'btn-secondary');
        modal_btn.setAttribute('data-dismiss', 'modal');
        modal_btn.innerHTML = btn_text;
        modal_footer.appendChild(modal_btn);

        return modal_btn;
    },

    reset: function(modal) {

        const modal_header = modal.children['0'].children['0'].children['0'];
        const modal_body = modal.children['0'].children['0'].children['1'];
        const modal_footer = modal.children['0'].children['0'].children['2'];

        modal_header.innerHTML = '';
        modal_body.innerHTML = '';
        modal_footer.innerHTML = '';

    }

}