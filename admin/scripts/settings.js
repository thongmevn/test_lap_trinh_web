
let general_data, contacts_data;

let general_s_form = document.getElementById('general_s_form');
let site_title_inp = document.getElementById('site_title_inp');
let site_about_inp = document.getElementById('site_about_inp');

let contacts_s_form = document.getElementById('contacts_s_form');

let team_s_form = document.getElementById('team_s_form');
let member_name_inp = document.getElementById('member_name_inp');
let member_picture_inp = document.getElementById('member_picture_inp');

function get_general()
{
  let site_title = document.getElementById('site_title');
  let site_about = document.getElementById('site_about');

  let shutdown_toggle = document.getElementById('shutdown-toggle');

  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/settings_crud.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function(){
    general_data = JSON.parse(this.responseText);
    
    site_title.innerText = general_data.site_title;
    site_about.innerText = general_data.site_about;

    site_title_inp.value = general_data.site_title;
    site_about_inp.value = general_data.site_about;

    if(general_data.shutdown == 0){
      shutdown_toggle.checked = false;
      shutdown_toggle.value = 0;
    }
    else{
      shutdown_toggle.checked = true;
      shutdown_toggle.value = 1;
    }
  }

  xhr.send('get_general');
}

general_s_form.addEventListener('submit',function(e){
  e.preventDefault();
  upd_general(site_title_inp.value,site_about_inp.value);
});

function upd_general(site_title_val,site_about_val)
{
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/settings_crud.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function(){
    var myModal = document.getElementById('general-s');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    if(this.responseText == 1)
    {
      alert('success','Changes saved!');
      get_general();
    }
    else
    {
      alert('error','No changes made!');
    }
  }

  let data = new URLSearchParams();
  data.append('site_title',site_title_val);
  data.append('site_about',site_about_val);
  data.append('upd_general','');

  xhr.send(data.toString());
}

function upd_shutdown(val)
{
  let shutdown_toggle = document.getElementById('shutdown-toggle');
  let new_status = shutdown_toggle.checked ? 1 : 0;

  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/settings_crud.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function(){
    if(this.responseText == 1 && new_status==1)
    {
      alert('success','Đã bật chế độ bảo trì!');
    }
    else if(this.responseText == 1)
    {
      alert('success','Đã tắt chế độ bảo trì!');
    }
    else
    {
      alert('error','Cập nhật bảo trì thất bại!');
    }
    get_general();
  }

  xhr.send('upd_shutdown='+new_status);
}

function get_contacts()
{
  let contacts_p_id = ['address','gmap','pn1','email','fb','insta','tw'];
  let iframe = document.getElementById('iframe');

  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/settings_crud.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function(){
    contacts_data = JSON.parse(this.responseText);

    for(i=0;i<contacts_p_id.length;i++){
      let current_el = document.getElementById(contacts_p_id[i]);
      if(current_el){
        current_el.innerText = contacts_data[contacts_p_id[i]] || '';
      }
    }
    iframe.src = contacts_data.iframe || '';
    contacts_inp(contacts_data);
  }

  xhr.send('get_contacts');
}

function contacts_inp(data)
{
  let contacts_inp_id = {
    address: 'address_inp',
    gmap: 'gmap_inp',
    pn1: 'pn1_inp',
    email: 'email_inp',
    fb: 'fb_inp',
    insta: 'insta_inp',
    tw: 'tw_inp',
    iframe: 'iframe_inp'
  };

  for(let key in contacts_inp_id){
    let current_inp = document.getElementById(contacts_inp_id[key]);
    if(current_inp){
      current_inp.value = data[key] || '';
    }
  }
}

contacts_s_form.addEventListener('submit',function(e){
  e.preventDefault();
  upd_contacts();
});

function upd_contacts()
{
  let fields = {
    address: 'address_inp',
    gmap: 'gmap_inp',
    pn1: 'pn1_inp',
    email: 'email_inp',
    fb: 'fb_inp',
    insta: 'insta_inp',
    tw: 'tw_inp',
    iframe: 'iframe_inp'
  };

  let data = new URLSearchParams();

  for(let key in fields){
    data.append(key,document.getElementById(fields[key]).value);
  }
  data.append('upd_contacts','');

  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/settings_crud.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function(){
    var myModal = document.getElementById('contacts-s');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();
    if(this.responseText == 1)
    {
      alert('success','Changes saved!');
      get_contacts();
    }
    else
    {
      alert('error','No changes made!');
    }
  }

  xhr.send(data.toString());
}

team_s_form.addEventListener('submit',function(e){
  e.preventDefault();
  add_member();
});

function add_member()
{
  let data = new FormData();
  data.append('name',member_name_inp.value);
  data.append('picture',member_picture_inp.files[0]);
  data.append('add_member','');

  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/settings_crud.php",true);

  xhr.onload = function(){
    var myModal = document.getElementById('team-s');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    if(this.responseText == 'inv_img'){
      alert('error','Only JPG and PNG images are allowed!');
    }
    else if(this.responseText == 'inv_size'){
      alert('error','Image should be less than 2MB!');
    }
    else if(this.responseText == 'upd_failed'){
      alert('error','Image upload failed. Server Down!');
    }
    else{
      alert('success','New member added!');
      member_name_inp.value='';
      member_picture_inp.value='';
      get_members();
    }
  }

  xhr.send(data);
}

function get_members()
{
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/settings_crud.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function(){
    document.getElementById('team-data').innerHTML = this.responseText;
  }

  xhr.send('get_members');
}

function rem_member(val)
{
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/settings_crud.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function(){
    if(this.responseText==1){
      alert('success','Member removed!');
      get_members();
    }
    else{
      alert('error','Server down!');
    }
  }

  xhr.send('rem_member='+val);
}

window.onload = function(){
  get_general();
  get_contacts();
  get_members();
}
