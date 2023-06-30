<script src="./plugins/jquery/jquery.min.js"></script>
        <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="./dist/js/adminlte.min.js"></script>
        <script src="./plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="./plugins/chart.js/Chart.min.js"></script>

    <!-- Importar AdminLTE script -->
    <script src="./dist/js/adminlte.min.js"></script>

  
        <script>
            $(document).ready(function() {
        function carregarConteudo(url) {
            {
                // Exibir feedback visual para o usuário
                $("#conteudo").html(`
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
      <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
  `);

                // Fazer uma solicitação ajax para obter os dados atualizados
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "html", // Especificar o tipo de dados esperado
                    success: function(result) {
                        // Verificar se o resultado é válido antes de atualizar o conteúdo
                        if (result.trim().length > 0) {
                            $("#conteudo").html(result);
                        } else {
                            $("#conteudo").html("Nenhum resultado encontrado.");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Exibir mensagem de erro com mais informações
                        $("#conteudo").html("Erro (" + jqXHR.status + "): " + errorThrown);
                    },
                    complete: function() {
                        // Remover o feedback visual
                        $("#conteudo .d-flex.justify-content-center.align-items-center").remove();
                    }
                });
            }
        }
    });
 
        </script>