import requests

r = requests.get(url='https://servicodados.ibge.gov.br/api/v1/paises/BR|RU|IN|CN|ZA/indicadores/77850')
data = r.json()[0]["series"]
print("hello world!\n")

def ordem(data):
    dado = {}
    for x in data:
        for y in x['serie']:
            for key in y.keys():
                if (y.get(key) is not None):
                    dict = {x["pais"]["id"] + key: [float(y.get(key)), x["pais"]["nome"], key]}
                    dado.update(dict)
    return dado

def sortTeen(dado):
    j = 1
    dados = {}
    for i in sorted(dado, key=dado.get, reverse=True):
        dados.update({i:dado[i]})
        if(j == 10):
            break
        j += 1
    return dados

dado = ordem(data)
dado = sortTeen(dado)
for i in dado:
    print(dado.get(i))
    print("-------")