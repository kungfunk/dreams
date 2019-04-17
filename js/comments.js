document.addEventListener('DOMContentLoaded', () => {
    const ajax_action = 'dreams_comment_submit';
    const button_text_loading = 'Publicando...';

    const comment_forms = document.querySelectorAll('.comments__form');
    const respond_links = document.querySelectorAll('.comment-reply-link');
    const original_form = document.querySelector('#commentform');

    function submitListener(event) {
        event.preventDefault();

        const form = this;
        const button = this.querySelector('input[type=submit]');
        const button_text_original = button.value;
        const comment_parent = this.querySelector('input[name=comment_parent]');
        const is_parent = comment_parent.value !== '0';
        let comment_list = null;
        let scroll_target = null;

        const setLoadingStatus = (button, loading_text) => {
            button.disabled = true;
            button.value = loading_text;
        };

        const setReadyStatus = (button, ready_text) => {
            button.disabled = false;
            button.value = ready_text;
        };

        const sendRequest = (data, successCallback, errorCallback) => {
            const request = new XMLHttpRequest();
            request.onload = () => successCallback(request.response);
            request.onerror = () => errorCallback(request.statusText);

            request.open('post', ajax_object.ajaxurl, true);
            request.send(data);
        };

        const getDataFromForm = form => {
            const formData = new FormData(form);
            formData.append('_ajax_nonce', ajax_object.ajax_nonce);
            formData.append('action', ajax_action);
            return formData;
        };

        const requestOnSuccess = comment => {
            if (is_parent) {
                comment_list = document.querySelector('#comment-' + comment_parent.value + ' .children');
                comment_list.innerHTML += comment;
                scroll_target = document.querySelector('#comment-' + comment_parent.value + ' .children > li:last-child');
                document.querySelector('.comment__reply--clicked').classList.remove('comment__reply--clicked');
            } else {
                comment_list = document.querySelector('.comments > .comments__list');
                comment_list.innerHTML += comment;
                scroll_target = document.querySelector('.comments .comments__list > li:last-child');
            }

            scroll_target.scrollIntoView({ behavior: 'smooth' });

            if (is_parent) {
                form.parentNode.removeChild(form);
            } else {
                form.reset();
            }

            setReadyStatus(button, button_text_original);
        };

        const requestOnError = error => {
            console.log('error', error);
            setReadyStatus(button, button_text_original);
        };

        setLoadingStatus(button, button_text_loading);
        sendRequest(getDataFromForm(form), requestOnSuccess, requestOnError);
    }

    function addCommentForm(event) {
        event.preventDefault();

        this.parentElement.classList.add('comment__reply--clicked');

        const cloned_form = original_form.cloneNode(true);
        cloned_form.addEventListener('submit', submitListener);
        cloned_form.id = 'cloned_commentform';
        cloned_form.reset();
        cloned_form.querySelector('input[name=comment_parent]').value = this.dataset.commentid;

        this.parentElement.parentElement.appendChild(cloned_form);
        cloned_form.querySelector('textarea').focus();
    }

    comment_forms.forEach(form => form.addEventListener('submit', submitListener));
    respond_links.forEach(link => link.addEventListener('click', addCommentForm));
});