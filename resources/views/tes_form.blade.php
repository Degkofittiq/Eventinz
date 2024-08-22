<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de service</title>
</head>
<body>
    <form id="serviceForm" method="POST" action="/addquote/2">
        @csrf
        <div id="serviceFields">
            <h3>Service 1</h3>
            <label>Nom du service: <input type="text" name="servicename[]" value="restauration"></label><br>
            <label>Type: <input type="text" name="type[]" value="fixed"></label><br>
            <label>Tarif: <input type="number" name="rate[]" value="500"></label><br>
            <label>Durée: <input type="text" name="duration[]" value="1 h"></label><br>
            <label>Total: <input type="number" name="total[]" value="500"></label><br>
            <label>Obligatoire: 
                <select name="obligatory[]">
                    <option value="yes" selected>Oui</option>
                    <option value="no">Non</option>
                </select>
            </label><br>
            <hr>
            <h3>Service 2</h3>
            <label>Nom du service: <input type="text" name="servicename[]" value="restauration"></label><br>
            <label>Type: <input type="text" name="type[]" value="fixed"></label><br>
            <label>Tarif: <input type="number" name="rate[]" value="500"></label><br>
            <label>Durée: <input type="text" name="duration[]" value="1 h"></label><br>
            <label>Total: <input type="number" name="total[]" value="500"></label><br>
            <label>Obligatoire: 
                <select name="obligatory[]">
                    <option value="yes" selected>Oui</option>
                    <option value="no">Non</option>
                </select>
            </label><br>
            <hr>
        </div>

        <label>Subdetails: <input type="text" name="subdetails" value=""></label><br>
        <label>Déplacement: 
            <select name="travel">
                <option value="yes" selected>Oui</option>
                <option value="no">Non</option>
            </select>
        </label><br>
        <button type="submit">Soumettre</button>
    </form>

    {{-- <script>
        document.getElementById('serviceForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const jsonData = {};

            formData.forEach((value, key) => {
                if (jsonData[key]) {
                    if (Array.isArray(jsonData[key])) {
                        jsonData[key].push(value);
                    } else {
                        jsonData[key] = [jsonData[key], value];
                    }
                } else {
                    jsonData[key] = value;
                }
            });

            console.log(JSON.stringify(jsonData, null, 2));
        });
    </script> --}}
</body>
</html>
