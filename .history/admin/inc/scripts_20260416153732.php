<script>
function alert(type, msg, position = 'body') {
    let css_class = (type == 'success') ? 'alert-success' : 'alert-danger';

    let element = document.createElement('div');
    element.className = `custom-alert ${css_class}`;
    element.innerHTML = `
    <span>${msg}</span>
    <button onclick="this.parentElement.remove()">×</button>
  `;

    if (position == 'body') {
        document.body.appendChild(element);
    } else {
        document.getElementById(position).appendChild(element);
    }

    setTimeout(() => {
        if (element) element.remove();
    }, 2000);
}


function setActive() {
    let navbar = document.getElementById('dashboard-menu');
    let a_tags = navbar.getElementsByTagName('a');

    for (let i = 0; i < a_tags.length; i++) {
        let file = a_tags[i].href.split('/').pop();
        let file_name = file.split('.')[0];

        if (document.location.href.indexOf(file_name) >= 0) {
            a_tags[i].classList.add('active');
        }
    }
}
setActive();
</script>

<style>
/* alert */
.custom-alert {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 12px 16px;
    border-radius: 6px;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 9999;
}

.custom-alert button {
    background: none;
    border: none;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
}

.alert-success {
    background: #198754;
}

.alert-danger {
    background: #dc3545;
}

/* active menu */
#dashboard-menu a.active {
    background: #0d6efd;
    border-radius: 4px;
}
</style>