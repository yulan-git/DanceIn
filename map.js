//Variables globales
let adresse = distance = "";
let myPosition = distance = "";

window.onload = () => {
    // on initialise la carte 
    let map = L.map('map').setView([48.852969, 2.349903], 11)
    
    //On charge les 'tuiles'
    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: 'Â© OpenStreetMap contributors',
    maxZoom: 18,
    minZoom: 1,
    name: 'tiles' // permettra de ne pas supprimer cette couche
}).addTo(map);

// Gestion des champs

let champAdresse = document.getElementById('champ-adresse');
let champDistance = document.getElementById('champs-distance');
let submit = document.getElementById('submit');
let valeurDistance = document.getElementById('valeur-distance');
let buttonGeo = document.getElementById('button-geo');



champAdresse.addEventListener("change", function () {
    
    // on envoie la requete ajax vers Nominatim
    ajaxGet(`https://nominatim.openstreetmap.org/search?q=${this.value}&format=json&addressdetails=1&limit=1&polygon_svg=1`)
    .then(reponse => {
        // on convertie la réponse en objet JS
        let data = JSON.parse(reponse);
        console.log(data);
        // On stocke les coordonnées dans ville
        adresse = [data[0].lat, data[0].lon];
        console.log(adresse);
        
        map.eachLayer(function (layer) {
            if (layer.options.name !== 'tiles') {
                map.removeLayer(layer);
            }
        })
        
        let marker = L.marker([data[0].lat, data[0].lon]).addTo(map);
        
        // On centre la carte sur la ville
        map.panTo(adresse);
    });
});
champDistance.addEventListener('change', function() {
    distance = champDistance.value;
    valeurDistance.innerText = distance + "km";
});

buttonGeo.addEventListener('click', currentLocation);
function currentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((function (position) {
            userlat = position.coords.latitude;
            userlon = position.coords.longitude;
            myPosition = [userlat, userlon];
            map.locate({ setView: true, maxZoom: 16 });
            var marker = L.marker([myPosition[0], myPosition[1]]).addTo(map);
        }));
    } else {
        alert("La géolocalisation n'est pas supportée par ce navigateur.");
    }
};


submit.addEventListener("click", function () {
    distance = champDistance.value;
    valeurDistance.innerText = distance + "km";
    let categ = document.getElementById("cat").options[document.getElementById('cat').selectedIndex];
    categorie = categ.value;
    let nivo = document.getElementById("niv").options[document.getElementById('niv').selectedIndex];
    niveau = nivo.value;
    let stl = document.getElementById("style").options[document.getElementById('style').selectedIndex];
    style = stl.value;
    let dateDebut = document.getElementById("dteTimeDebut");
    dateTimeDebut = dateDebut.value;
    let dateFin = document.getElementById("dteTimeFin");
    dateTimeFin = dateFin.value;
    //on vérifie qu'on a une adresse  
    
    if (adresse !== "" ) {
        //on envoie la requete
        ajaxGet(`http://localhost/SiteDance/filtre.php?latGPS=${adresse[0]}&lonGPS=${adresse[1]}&categorie=${categorie}&style=${style}&niveau=${niveau}&dateTimeDebut=${dateTimeDebut}&dateTimeFin=${dateTimeFin}&distance=${distance}`).then(reponse => {
        
        document.getElementById('event').innerHTML = "";
        //On supprime toutes les couches de la carte
        map.eachLayer(function (layer) {
            if (layer.options.name !== 'tiles') {
                map.removeLayer(layer);
            }
        })
        // On trace un cercle correspondant à la distance souhaité
        let circle = L.circle(adresse, {
            color: '#839c49',
            fillColor: '#839c49',
            fillOpacity: 0.3,
            radius: distance * 1000
        }).addTo(map);
        
        //On boucle sur les données
        let data = JSON.parse(reponse);
        console.log(data);
        if (data == "") {
            document.getElementById('event').innerHTML = '<div class="alert"><i class="fas fa-ban"></i>&nbsp;Aucun évènement trouvé</div>';
        } else {
            for (let i = 0; i < data.length; i++) {
                    //alert(data[i].nom_event);
                    document.getElementById('event').innerHTML += '<i class="fas fa-star">&nbsp;</i><a href="">' + data[i].nom_event + '</a> - ' + moment(data[i].date_debut).format('DD/MM/YYYY') + '<br>';
                }
            }
        Object.entries(data).forEach(event => {
            //On crée le marqueur
            
            //console.log(event) -> TABLEAU event pointe sur le deuxième objet, le premier c'est l'id
            let marker = L.marker([event[1].latGPS, event[1].lonGPS]).addTo(map);
            marker.bindPopup(event[1].nom_event);
            
        })
        
        //On centre la carte sur le cercle
        let bounds = circle.getBounds();
        map.fitBounds(bounds);
        
    });
}

if (myPosition !== "") {
    
    ajaxGet(`http://localhost/SiteDance/filtre.php?latGPS=${myPosition[0]}&lonGPS=${myPosition[1]}&categorie=${categorie}&style=${style}&niveau=${niveau}&dateTimeDebut=${dateTimeDebut}&dateTimeFin=${dateTimeFin}&distance=${distance}`).then(reponse => {
    
    //On supprime toutes les couches de la carte
    map.eachLayer(function (layer) {
        if (layer.options.name !== 'tiles') {
            map.removeLayer(layer);
        }
    })
    // On trace un cercle correspondant à la distance souhaité
    let circle = L.circle(myPosition, {
        color: '#839c49',
        fillColor: '#839c49',
        fillOpacity: 0.3,
        radius: distance * 1000
    }).addTo(map);
    
    //On boucle sur les données
    let data = JSON.parse(reponse);
    console.log(data);
    
    Object.entries(data).forEach(event => {
        //On crée le marqueur
        //console.log(event) -> TABLEAU event pointe sur le deuxième objet, le premier c'est l'id
        console.log(event);
        let marker = L.marker([event[1].latGPS, event[1].lonGPS]).addTo(map);
        marker.bindPopup(event[1].nom_event);
        console.log(event);
        //console.log(event);
    })
    
    //On centre la carte sur le cercle
    let bounds = circle.getBounds();
    map.fitBounds(bounds);
    
});
};
});

};




// fonction qui effectue un appel Ajax vers une url et retourne une promesse
function ajaxGet(url) {
    return new Promise(function (resolve, reject) {
        //nous allons gérer la promesse
        let xmlhttp = new XMLHttpRequest();
        
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4) {
                if (xmlhttp.status == 200) {
                    resolve(xmlhttp.response);
                } else {
                    reject(xmlhttp);
                }
            }
        }
        
        xmlhttp.onerror = function (error) {
            reject(error);
        }
        
        xmlhttp.open('get', url, true);
        xmlhttp.send();
    });
}

/**
* Récupérer les coordonnées de l'adresse
*/
let ville = document.querySelector('#ville');
ville.addEventListener('change', function () {
    // On "fabrique" l'adresse complète (des vérifications préalables seront nécessaires)
    let adresse = document.querySelector("#adressePrincipale").value + ", " + document.querySelector("#cp").value + " " + document.querySelector("#ville").value;
    
    // On initialise la requête Ajax
    const xmlhttp = new XMLHttpRequest
    
    // On détecte les changements d'état de la requête
    xmlhttp.onreadystatechange = () => {
        // Si la requête est terminée
        if (xmlhttp.readyState == 4) {
            // Si nous avons une réponse
            if (xmlhttp.status == 200) {
                // On récupère la réponse
                let response = JSON.parse(xmlhttp.response)
                
                // On récupère la latitude et la longitude
                let lat = response[0]['lat']
                let lon = response[0]['lon']
                
                // On écrit les valeurs dans le formulaire
                document.querySelector("#lat").value = lat;
                document.querySelector("#lon").value = lon;
                
            }
        }
    }
    
    // On ouvre la requête
    xmlhttp.open('get', `https://nominatim.openstreetmap.org/search?q=${adresse}&format=json&addressdetails=1&limit=1&polygon_svg=1`)
    
    // On envoie la requête
    xmlhttp.send();
    
});
