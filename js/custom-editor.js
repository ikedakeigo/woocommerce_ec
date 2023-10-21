document.addEventListener('DOMContentLoaded', function() {
  const elements = document.querySelectorAll('.wrap');

  elements.forEach(element => {
    let content = element.innerHTML;
    content = content.replace(/TCD/g, '');

    element.innerHTML = content;
  });
});
