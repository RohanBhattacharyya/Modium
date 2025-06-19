<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modium</title>

    <script>
    function displayMods(json){
        mods.innerHTML = "";
        json.sort((a,b) => b.downloads - a.downloads);
        json.forEach(mod => {
            toAdd = `
                <h2><a target="_blank" href=${mod.link[0]}>${mod.name}</a></h2>
                ${(()=>{
                    toAdd = "";
                    mod.link.forEach(thing => {
                        toAdd += `
                        <a href="${thing}" target="_blank"><img style="height: 1.5rem" src="${thing.includes("modrinth.com") ? "images/modrinth.ico" : "images/curseforge.ico"}"></a>
                        `;
                        console.log(thing);
                        console.log(thing.includes("modrinth.com"));
                    });
                    return toAdd;
                }
                )()
                }
                <p>All Sites Downloads (apprx): ${(mod.downloads).toLocaleString('en-US')}</p>
                <br>
                <img height=200px src="${mod.art}">
                <p>${mod.description}</p>
                <hr>
            `;
            mods.innerHTML+= toAdd;
        });
    }
    function fetchJSON(name){
        name = encodeURIComponent(name);
        fetch(`scripts/unified.php?name=${name}`)
            .then(response => response.json())
            .then(data => {
                displayMods(data);
            })
        ;
    }
</script>

<link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1 class="modium">Modium</h1>
        <span>
            <input id="search" type="text">
            <button onclick="fetchJSON(search.value)">Search</button>
        </span>
        <script>
            document.querySelector("#search").addEventListener("keyup", function(event) {
                if (event.key === "Enter") {
                    fetchJSON(search.value);
                }
            })
        </script>
    </header>
    <main>
        <div id="mods">
    
        </div>
    </main>
</body>
</html>

