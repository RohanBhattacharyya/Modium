<h1>Modium</h1>
<input id="search" type="text">
<script>
    function displayMods(json){
        mods.innerHTML = "";
        json.forEach(mod => {
            toAdd = `
                <h2><a target="_blank" href=${mod.link}>${mod.name}</a></h2>
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
<button onclick="fetchJSON(`${search.value}`)">Search</button>
<div id="mods">

</div>