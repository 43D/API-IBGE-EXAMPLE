<?php
$json = file_get_contents('https://servicodados.ibge.gov.br/api/v1/paises/BR|RU|IN|CN|ZA/indicadores/77850');
$obj = json_decode($json);
$dados = filtro($obj[0]->series);
$dados = ordenacao($dados);

function filtro(array $dado): array
{
    $res = [];
    foreach ($dado as $key => $value) {
        foreach ($value->serie as $key2 => $value2) {
            foreach ($value2 as $key3 => $value3) {
                if ($value3 != null) {
                    $res += array($value->pais->id . "#" . $key3 => [(float) $value3, $value->pais->nome, $key3]);
                }
            }
        }
    }
    return $res;
}

function ordenacao(array $dado): array
{
    $res = [];
    rsort($dado);
    $i = 0;
    foreach ($dado as $key => $value) {
        $i++;
        $res += array($key => $value);
        if ($i == 10) {
            break;
        }
    }
    return $res;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 10</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Rússia, China, Brasil, África do Sul e Índia</h2>
                <h4>Top 10 mortalidade do BRICS</h4>
            </div>
            <div class="col-12">
                <table class="table table-striped table-hover">
                    <caption style="caption-side:bottom">Fonte: <a href="https://servicodados.ibge.gov.br/api/docs/paises" target="_blank">IBGE</a></caption>
                    <thead>
                        <tr>
                            <th scope="col">Pais</th>
                            <th scope="col">Ano</th>
                            <th scope="col">mortalidade</th>
                        </tr>
                    </thead>
                    <tbody id="tb">
                        <?php
                        foreach ($dados as $key => $value) {
                            echo "<tr><td>" . $value[1] . "</td><td>" . $value[2] . "</td><td>" . $value[0] . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>

</html>