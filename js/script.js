document.querySelector('#theme-switch').addEventListener('click', function() {
    document.body.setAttribute('data-theme', document.body.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
});
