<?php
include '../z/config.php';
require_once 'ComponentesVisualizacao.php';
require_once 'querys-dash.php';

$querysComponentes = $resultados;
$davizaun = getGraf($graficos);
//echo json_encode($graficos);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Página de Configuração</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="./dist//css//bootstrap.min.css">
</head>

<?php include 'cabecalho.php'; ?>

<body>

    <div class="container">
        <button id="voltarBtn" class="btn btn-primary">Voltar</button>

        <h1>Gráficos existentes:</h1>

        <div class="row">
            <?php foreach ($querysComponentes as $grafico) { ?>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h3 class="card-title">
                                <?php echo $grafico->nome; ?>
                            </h3>
                            <p class="card-text">
                                <?php echo $grafico->descricao; ?>
                            </p>
                            <button class="btn btn-primary" data-toggle="modal"
                                data-target="#editarModal_<?php echo $grafico->id; ?>">Editar</button>
                        </div>
                    </div>
                </div>

                <!-- Modal para edição do gráfico -->
                <div class="modal fade" id="editarModal_<?php echo $grafico->id; ?>" tabindex="-1" role="dialog"
                    aria-labelledby="editarModalLabel_<?php echo $grafico->id; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editarModalLabel_<?php echo $grafico->id; ?>">Editar Gráfico
                                    - <?php echo $grafico->nome; ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulário para editar as propriedades do gráfico -->
                                <form action="processar_edicao.php" method="POST">
                                    <div class="form-group">
                                        <label for="descricao_<?php echo $grafico->id; ?>">Titulo:</label>
                                        <input type="text" id="descricao_<?php echo $grafico->id; ?>" name="descricao"
                                            value="<?php echo $grafico->descricao; ?>" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="titulo_<?php echo $grafico->id; ?>">Nome:</label>
                                        <input type="text" id="titulo_<?php echo $grafico->id; ?>" name="titulo"
                                            value="<?php echo $grafico->nome; ?>" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="cor_<?php echo $grafico->id; ?>">Cor:</label>
                                        <input type="text" id="cor_<?php echo $grafico->id; ?>" name="cor"
                                            value="<?php echo $grafico->cor; ?>" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="ordem_exib_<?php echo $grafico->id; ?>">Ordem de
                                            Exibição:</label>
                                        <input type="number" id="ordem_exib_<?php echo $grafico->id; ?>" name="ordem_exib"
                                            value="<?php echo $grafico->ordem_exib; ?>" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="tempo_refresh_<?php echo $grafico->id; ?>">Tempo de
                                            Atualização (minutos):</label>
                                        <input type="number" id="tempo_refresh_<?php echo $grafico->id; ?>"
                                            name="tempo_refresh" value="<?php echo $grafico->tempo_refresh; ?>" required
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="type_<?php echo $grafico->id; ?>">Tipo de Gráfico:</label>
                                        <select id="type_<?php echo $grafico->id; ?>" name="type" class="form-control"
                                            required>
                                            <?php
                                            // Gerar as opções no formulário
                                            foreach ($graficos as $cada) {
                                                $selected = ($grafico->id_mod_dashboard == $cada->id) ? 'selected' : '';

                                                echo '<option value="' . $cada->id . '" ' . $selected . '>' . $cada->nome . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="query_<?php echo $grafico->id; ?>">Query:</label>
                                        <textarea id="query_<?php echo $grafico->id; ?>" name="query" required
                                            class="form-control"><?php echo $grafico->query; ?></textarea>
                                    </div>

                                    <input type="hidden" name="grafico_id" value="<?php echo $grafico->id; ?>">
                                    <input type="submit" value="Salvar" class="btn btn-primary">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <h1>Adicionar novo gráfico:</h1>
        <form action="processar_configuracao.php" method="POST">
            <div class="form-group">
                <label for="titulo">Título do gráfico:</label>
                <input type="text" id="titulo" name="titulo" required class="form-control">
            </div>

            <!-- Outros campos do formulário, como tipo de gráfico, informações, etc. -->

            <input type="submit" value="Adicionar" class="btn btn-primary">
        </form>

        <button class="btn btn-primary" onclick="adicionarGrafico()">+</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            // ...

            // Manipulador de evento de clique para o botão de voltar
            $('#voltarBtn').click(function () {
                window.location.href = 'starter.php'; // Substitua 'pagina-de-origem.html' pelo URL da página de origem
            });
        });

        function editarGrafico(id) {
            // Lógica para manipular a edição do gráfico com o ID especificado
            // por exemplo, preencher o formulário no modal com os dados do gráfico
            // e exibir o modal
            $('#titulo_' + id).val('<?php echo $grafico->nome; ?>');
            $('#descricao_' + id).val('<?php echo $grafico->descricao; ?>');
            $('#cor_' + id).val('<?php echo $grafico->cor; ?>');
            $('#ordem_exib_' + id).val('<?php echo $grafico->ordem_exib; ?>');
            $('#tempo_refresh_' + id).val('<?php echo $grafico->tempo_refresh; ?>');
            $('#type_' + id).val('<?php echo $grafico->type; ?>');
            $('#query_' + id).val("<?php echo $grafico->query; ?>");

            $('#editarModal_' + id).modal('show');
        }

        function adicionarGrafico() {
            // Lógica para adicionar um novo gráfico, como redirecionar para uma página de criação de gráficos
        }
    </script>
</body>

</html>