$(document).ready(function() {

    $( '#sidebarCollapse' ).on( 'click', function() {

        $( '#sidebar' ).toggleClass('open');

    });

});

console.log('coucou')
let serieTag = document.getElementById('serieTag')
let filmTag = document.getElementById('filmTag')
let contactTag = document.getElementById('contactTag')
let profilTag = document.getElementById('profilTag')

filmTag.addEventListener('click', (e) =>{
    filmTag.classList.add('active')
    serieTag.classList.remove('active')
    contactTag.classList.remove('active')
    profilTag.classList.remove('active')
    window.location.href = filmTag.getAttribute('href');
})

serieTag.addEventListener('click', (e) =>{
    serieTag.classList.add('active')
    filmTag.classList.remove('active')
    contactTag.classList.remove('active')
    profilTag.classList.remove('active')
    window.location.href = serieTag.getAttribute('href');
})

profilTag.addEventListener('click', (e) =>{
    contactTag.classList.remove('active')
    filmTag.classList.remove('active')
    serieTag.classList.remove('active')
    profilTag.classList.add('active')
    window.location.href = filmTag.getAttribute('href');
})

contactTag.addEventListener('click', (e) =>{
    contactTag.classList.add('active')
    filmTag.classList.remove('active')
    serieTag.classList.remove('active')
    profilTag.classList.remove('active')
    window.location.href = filmTag.getAttribute('href');
})

let btnModUser = document.getElementById('modProfil');
btnModUser.addEventListener("click", (e) => {
    e.preventDefault();
});
let btnConfirm = document.getElementById('actualPasswordConfirmation')
btnConfirm.addEventListener("click", (e) => {
    e.preventDefault()
    let data = {};
    data.email = document.getElementById('email').value
    data.password = document.getElementById('password').value
    data.confirm = document.getElementById('password_confirm').value
    data.actualPassword = document.getElementById('actualPassword').value
    console.log(data)
    postUserData(data);
    document.getElementById('actualPassword').value = ''
    document.getElementById('password_confirm').value = ''
    document.getElementById('email').value = ''
    document.getElementById('password').value = ''
})


async function postUserData(data){
    console.log(data)
    let formData = new FormData();
    Object.keys(data).forEach((key) => {
        formData.append(key, data[key])
    })
    const response = await fetch('http://localhost/codFlix/model/userMod.php', {
        method : 'POST',
        body: formData
    })
    let json = await response.json();
    if (json.status === 'success'){
        console.log(json.message)
        alert(json.message)
    }
    console.log(json);
}



