document.addEventListener('DOMContentLoaded',function(){
 document.querySelectorAll('[data-confirm]').forEach(function(el){el.addEventListener('click',function(e){if(!confirm(el.getAttribute('data-confirm')||'Are you sure?'))e.preventDefault();});});
 document.querySelectorAll('form.needs-validation').forEach(function(form){form.addEventListener('submit',function(event){if(!form.checkValidity()){event.preventDefault();event.stopPropagation();}form.classList.add('was-validated');},false);});
});
