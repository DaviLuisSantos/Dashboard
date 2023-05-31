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
    $tempoRefresh =  strtotime('+' . 2 . ' minutes');
    $currentTimestamp = time(); // Obtém o timestamp do tempo atual1201
    $ttempoRefresh = strtotime($tempoRefresh)+120;

    $html = '

    <div class="card">
      <div class="card-header" style="background-color:#' . $this->cor . '">
        <h3 class="card-title text-' . $contrastColor . '">' . $this->descricao . '</h3>
      </div>
      <div class="card-body">
      <canvas id="' . $this->nome . 'Chart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;" dataTempoRefresh="' . $tempoRefresh . '"></canvas>

      </div>
    </div>

  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="plugins/chart.js/Chart.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
  <script>
    var ctx = document.getElementById("' . $this->nome . 'Chart").getContext("2d");
    var ' . $this->nome . 'Chart = new Chart(ctx, ' . json_encode($this->config) . ');

    setInterval(function () {
      var tempoRefresh= document.getElementById("' . $this->nome . 'Chart").getAttribute("dataTempoRefresh");
      var currentTime = new Date().getTime();
      if (currentTime >= tempoRefresh) {
        document.getElementById("' . $this->nome . 'Chart").setAttribute("dataTempoRefresh",new Date().getTime()+2*60*1000);
        atualizarChart("' . $this->nome . '");
      }
    }, 10000); // Intervalo definido como 120.000 milissegundos (2 minutos)




  </script>';
    return $html;
  }
}

class Box
{
  private $bgColor;
  private $valor;
  private $titulo;

  public function __construct($bgColor, $valor, $titulo)
  {
    $this->bgColor = $bgColor;
    $this->valor = $valor;
    $this->titulo = $titulo;

  }

  public function render()
  {
    $contrastColor = getContrastColor($this->bgColor);
    return '
    <div class="col-lg-4 col-6">
    <div class="small-box" style="background-color: #' . $this->bgColor . '">
      <div class="inner">
        <h3 class="text-' . $contrastColor . '">' . $this->valor . '</h3>
        <p class="text-' . $contrastColor . '">' . $this->titulo . '</p>
      </div>
    </div>
    </div>
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>';
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
