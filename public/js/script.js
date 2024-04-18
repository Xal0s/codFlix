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
btnModUser.addEventListener("click", async (e) => {
    e.preventDefault();
    let data = {
        email: document.getElementById('email').value,
        password: document.getElementById('password').value,
        confirm: document.getElementById('password_confirm').value,
        actualPassword: document.getElementById('actualPassword').value // Ajout du mot de passe actuel
    };

    if (data.password === data.confirm) {
        try {
            const response = await postUserData(data);
            if (response.status === 'success') {
                console.log(response.message);
                alert(response.message);
            } else {
                console.error(response.message);
                alert('Une erreur est survenue lors du traitement de votre demande.');
            }
        } catch (error) {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors du traitement de votre demande.');
        }
    } else {
        alert('Les mots de passe ne correspondent pas.');
    }
});


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



