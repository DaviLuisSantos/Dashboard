<?php
include '../z/config.php';
class Chart
{
  private $type;
  private $labels;
  private $data;
  private $cor;
  private $nome;
  private $config;
  private $descricao;
  private $tempoRefresh;

  public function __construct($nome, $descricao, $type, $labels, $data, $cor, $tempoRefresh = 0)
  {
    $this->type = $type;
    $this->labels = $labels;
    $this->data = $data;
    $this->cor = $cor;
    $this->nome = $nome;
    $this->descricao = $descricao;
    $this->tempoRefresh = $tempoRefresh;

    // Define as opções padrão do Chart
    $options = array(
      'responsive' => true,
      'maintainAspectRatio' => true,
      'legend' => array(
        'position' => 'top'
      )
    );

    // Define as configurações específicas para cada tipo de gráfico
    switch ($type) {
      case 'line':
        $config = array(
          'type' => $type,
          'data' => array(
            'labels' => $this->labels,
            'datasets' => array(
              array(
                'label' => $this->descricao,
                'backgroundColor' => '#' . $this->cor,
                'borderColor' => '#' . $this->cor,
                'lineTension' => 0,
                'fill' => false,
                'data' => $this->data
              )
            )
          ),
          'options' => $options
        );
        break;
      case 'bar':
        $cores = array();
        for ($i = 0; $i < count($this->data); $i++) {
          $cores[] = $this->gerar_cor_aleatoria();
        }

        $config = array(
          'type' => $type,
          'data' => array(
            'labels' => $this->labels,
            'datasets' => array(
              array(
                'label' => $this->descricao,
                'backgroundColor' => $cores,
                //'borderColor' => 'rgba(60,141,188,0.8)',
                'data' => $this->data
              )
            )
          ),
          'options' => $options
        );
        break;
      case 'pie':
        $cores = array();
        for ($i = 0; $i < count($this->data); $i++) {
          $cores[] = $this->gerar_cor_aleatoria();
        }

        $config = array(
          'type' => $type,
          'data' => array(
            'labels' => $this->labels,
            'datasets' => array(
              array(
                'label' => $this->descricao,
                'backgroundColor' => $cores,
                //'borderColor' => '#000000',
                'data' => $this->data
              )
            )
          ),
          'options' => $options
        );
        break;
      // Adicione mais casos para outros tipos de gráficos, se necessário
      default:
        $config = null;
        break;
    }

    $this->config = $config;
  }

  public function toJson()
  {
    return json_encode($this->config);
  }

  private function gerar_cor_aleatoria()
  {
    $hex = str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    return '#' . $hex;
  }

  public function render()
{
  $contrastColor = getContrastColor($this->cor);
  $tempoRefresh = time() + ($this->tempoRefresh * 60); // Adiciona 2 minutos ao tempo atual
  $currentTimestamp = time();
  $ttempoRefresh = strtotime($tempoRefresh);

  $html = '
  <div class="card">
    <div class="card-header" style="background-color:#' . $this->cor . '">
      <h3 class="card-title text-' . $contrastColor . '">' . $this->descricao . '</h3>
    </div>
    <div class="card-body">
      <canvas class="chart" id="' . $this->nome . 'Chart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;" data-tempo-refresh="' . $tempoRefresh . '"></canvas>
    </div>
  </div>

  <script>
    var ctx = document.getElementById("' . $this->nome . 'Chart").getContext("2d");
    var ' . $this->nome . 'Chart = new Chart(ctx, ' . json_encode($this->config) . ');

    setInterval(function () {
      setTimeout(function(){
      var tempoRefresh = parseInt(document.getElementById("' . $this->nome . 'Chart").getAttribute("data-tempo-refresh"));
      var currentTime = Math.floor(Date.now() / 1000); // Obtém o tempo atual em segundos

      if (currentTime >= tempoRefresh) {
        var tempoRefresh = parseInt(document.getElementById("' . $this->nome . 'Chart").setAttribute("data-tempo-refresh", Math.floor(Date.now() / 1000)+120000));
        atualizarChart("' . $this->nome . '");
      }
    },1000);
    }, 1000);
  </script>';

  return $html;
}

}

class Box
{
  private $bgColor;
  private $valor;
  private $titulo;
  private $nome;
  private $tempoRefresh;

  public function __construct($bgColor, $valor, $titulo,$nome,$tempoRefresh=0)
  {
    $this->bgColor = $bgColor;
    $this->valor = $valor;
    $this->titulo = $titulo;
    $this->nome=$nome;
    $this->tempoRefresh=$tempoRefresh;

  }

  public function render()
  {
    $contrastColor = getContrastColor($this->bgColor);
    $tempoRefresh = time() + ($this->tempoRefresh * 60); // Adiciona 2 minutos ao tempo atual
  $currentTimestamp = time();
  $ttempoRefresh = strtotime($tempoRefresh);

    $html= '
    <div class="small-box" style="background-color: #' . $this->bgColor . '">
      <div class="inner">
        <h3 class="text-' . $contrastColor . '" id="' . $this->nome . 'Chart" data-tempo-refresh="' . $tempoRefresh . '" >' . $this->valor . '</h3>
        <p class="text-' . $contrastColor . '">' . $this->titulo . '</p>
      </div>
    </div>
    <script>
    setInterval(function () {
      var tempoRefresh = parseInt(document.getElementById("' . $this->nome . 'Chart").getAttribute("data-tempo-refresh"));
      var currentTime = Math.floor(Date.now() / 1000); // Obtém o tempo atual em segundos

      if (currentTime >= tempoRefresh) {
        var tempoRefresh = parseInt(document.getElementById("' . $this->nome . 'Chart").setAttribute("data-tempo-refresh", Math.floor(Date.now() / 1000)+120000));
        atualizarChart("' . $this->nome . '");
      }
    }, 1000);
  </script>';

    return $html;
  }
}

function getContrastColor($hexColor)
{
  $r = hexdec(substr($hexColor, 0, 2));
  $g = hexdec(substr($hexColor, 2, 2));
  $b = hexdec(substr($hexColor, 4, 2));
  $luma = ($r * 0.299 + $g * 0.587 + $b * 0.114) / 255;
  return $luma > 0.5 ? 'black' : 'white';
}

?>
