document.addEventListener('DOMContentLoaded', function(){

    eventListeners(); //En cuanto este cargado el documento va a cargar esta función 

    darkMode();
});

function darkMode() {

    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)'); //De este modo tenemos las preferencias del ususario en el sistema operativo

    // console.log(prefiereDarkMode.matches);

    if(prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode') // Se le agrega la clase 'dark-mode' al body
    }else{
        document.body.classList.remove('dark-mode') // Se le elimina la clase 'dark-mode' al body
    }

    prefiereDarkMode.addEventListener('change', function() { // Si el usuario cambia en ese momento de tema en el sistema operativo, se podra escuchar y cambiar el tema en tiempo real
        if(prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode')
        }else{
            document.body.classList.remove('dark-mode')
        }
    })

    const botonDarkMode = document.querySelector('.dark-mode-boton');

    botonDarkMode.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode'); //Toggle: si tiene la calse la quita y si no la tiene la agrega
    });
}

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive); //Para que se ejecute la funcion basta con solo nombrar la funcion 
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');

    // navegacion.classList.toggle('mostrar'); //Toggle: si tiene la calse la quita y si no la tiene la agrega

    if(navegacion.classList.contains('mostrar')) {
        navegacion.classList.remove('mostrar');
    } else {
        navegacion.classList.add('mostrar');
    }
}