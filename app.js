$(document).ready(async function () {
    let morte = await getJs(77850);
    let lista = listar(morte);
    lista = ordem(lista);
    $.each(lista, function (key, value) {
        console.log(key)
    });
    preencher(lista);
});

async function getJs(id) {
    return await getJsonPromise(id).then(resultado => {
        return resultado;
    });
}
function getJsonPromise(id) {
    return new Promise((resolve, reject) => {
        let a = "https://servicodados.ibge.gov.br/api/v1/paises/BR|RU|IN|CN|ZA/indicadores/" + id;
        let j = $.getJSON(a);
        resolve(j);
    });
}

function listar(morte) {
    const map = new Map();
    for (var i = 0; i < morte[0]["series"].length; i++) {
        for (var j = 1; j < morte[0]["series"][i]["serie"].length; j++) {
            $.each(morte[0]["series"][i]["serie"][j], function (key, value) {
                if (value) {
                    map.set(morte[0]["series"][i]["pais"]["id"] + key, [value, morte[0]["series"][i]["pais"]["nome"], key]);
                }
            });
        }
    }
    return map;
}

function ordem(map) {
    let list = new Map([...map].sort(
        function (a, b) {
            if (parseFloat(a[1][0]) < parseFloat(b[1][0])) {
                return 1;
            }
            if (parseFloat(a[1][0]) > parseFloat(b[1][0])) {
                return -1;
            }
            return 0;
        }
    ));
    return list;
}

function preencher(list) {
    let tbody = document.getElementById("tb");
    let keys = [...list.keys()];
    keys = keys.slice(0, 10)
    for (i = 0; i < keys.length; i++) {
        let markup = "<tr><td>" + list.get(keys[i])[1] + "</td>";
        markup += "<td>" + list.get(keys[i])[2] + " </td>";
        markup += "<td>" + list.get(keys[i])[0] + "</td>";
        markup += "</tr>";
        let tb = $("#tb");
        tb.append(markup)
    }
}