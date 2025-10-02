<?php
/**
 * Sistema de Controle de Vendas e Estoque
 * Samambaia Papelaria
 */
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Samambaia Papelaria - Sistema de Controle</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        header {
            background: linear-gradient(135deg, #2e7d32 0%, #43a047 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(46, 125, 50, 0.3);
            margin-bottom: 30px;
            text-align: center;
        }

        header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-left: 5px solid #4caf50;
        }

        .stat-card h3 {
            color: #2e7d32;
            font-size: 1em;
            margin-bottom: 10px;
        }

        .stat-card .value {
            color: #1b5e20;
            font-size: 2.5em;
            font-weight: bold;
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .form-section, .table-section {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .form-section h2, .table-section h2 {
            color: #2e7d32;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #4caf50;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #2e7d32;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #a5d6a7;
            border-radius: 8px;
            font-size: 1em;
            transition: all 0.3s;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #4caf50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2e7d32 0%, #43a047 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 125, 50, 0.4);
        }

        .btn-success {
            background: #4caf50;
            color: white;
            padding: 8px 15px;
            font-size: 0.9em;
        }

        .btn-danger {
            background: #f44336;
            color: white;
            padding: 8px 15px;
            font-size: 0.9em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background: linear-gradient(135deg, #2e7d32 0%, #43a047 100%);
            color: white;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9em;
        }

        tbody tr {
            transition: all 0.3s;
        }

        tbody tr:hover {
            background: #f1f8e9;
            transform: scale(1.01);
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }

        .alert-success {
            background: #c8e6c9;
            color: #1b5e20;
            border-left: 5px solid #4caf50;
        }

        .alert-error {
            background: #ffcdd2;
            color: #b71c1c;
            border-left: 5px solid #f44336;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 500px;
            width: 90%;
        }

        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
            }
            
            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>🌿 Samambaia Papelaria</h1>
            <p>Sistema de Controle de Vendas e Estoque</p>
        </header>

        <div id="alertBox" class="alert"></div>

        <div class="stats">
            <div class="stat-card">
                <h3>Total de Produtos</h3>
                <div class="value" id="totalProdutos">0</div>
            </div>
            <div class="stat-card">
                <h3>Total de Vendas</h3>
                <div class="value" id="totalVendas">0</div>
            </div>
            <div class="stat-card">
                <h3>Valor Total Vendido</h3>
                <div class="value" id="valorTotal">R$ 0,00</div>
            </div>
        </div>

        <div class="main-content">
            <div class="form-section">
                <h2>Cadastro de Produtos</h2>
                <form id="produtoForm">
                    <div class="form-group">
                        <label for="nome">Nome do Produto *</label>
                        <input type="text" id="nome" name="nome" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <textarea id="descricao" name="descricao"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="preco">Preço (R$) *</label>
                        <input type="number" id="preco" name="preco" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="quantidade">Quantidade *</label>
                        <input type="number" id="quantidade" name="quantidade" min="0" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Cadastrar Produto</button>
                </form>
            </div>

            <div class="table-section">
                <h2>Produtos em Estoque</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="produtosTable">
                        <!-- Produtos serão inseridos aqui via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="table-section">
            <h2>Histórico de Vendas</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Valor Total</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody id="vendasTable">
                    <!-- Vendas serão inseridas aqui via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Venda -->
    <div id="vendaModal" class="modal">
        <div class="modal-content">
            <h2 style="color: #2e7d32; margin-bottom: 20px;">Registrar Venda</h2>
            <form id="vendaForm">
                <input type="hidden" id="vendaProdutoId">
                <div class="form-group">
                    <label>Produto:</label>
                    <input type="text" id="vendaProdutoNome" readonly style="background: #f5f5f5;">
                </div>
                <div class="form-group">
                    <label>Quantidade Disponível:</label>
                    <input type="text" id="vendaEstoqueDisponivel" readonly style="background: #f5f5f5;">
                </div>
                <div class="form-group">
                    <label for="vendaQuantidade">Quantidade a Vender *</label>
                    <input type="number" id="vendaQuantidade" min="1" required>
                </div>
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn btn-primary" style="width: 50%;">Confirmar</button>
                    <button type="button" class="btn btn-danger" onclick="fecharModal()" style="width: 50%;">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const API_URL = 'api.php';

        // Funções de inicialização
        function init() {
            carregarProdutos();
            carregarVendas();
            carregarEstatisticas();
        }

        // Carregar produtos via AJAX
        async function carregarProdutos() {
            try {
                const response = await fetch(`${API_URL}?acao=listar_produtos`);
                const data = await response.json();
                
                if (data.success) {
                    const tbody = document.getElementById('produtosTable');
                    tbody.innerHTML = '';
                    
                    data.data.forEach(produto => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${produto.id_produto}</td>
                            <td><strong>${produto.nome}</strong></td>
                            <td>${produto.descricao || '-'}</td>
                            <td>R$ ${parseFloat(produto.preco).toFixed(2)}</td>
                            <td>${produto.quantidade_estoque}</td>
                            <td class="actions">
                                <button class="btn btn-success" onclick="abrirModalVenda(${produto.id_produto}, '${produto.nome}', ${produto.quantidade_estoque})">Vender</button>
                                <button class="btn btn-danger" onclick="excluirProduto(${produto.id_produto})">Excluir</button>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            } catch (error) {
                console.error('Erro ao carregar produtos:', error);
                mostrarAlerta('Erro ao carregar produtos', 'error');
            }
        }

        // Carregar vendas via AJAX
        async function carregarVendas() {
            try {
                const response = await fetch(`${API_URL}?acao=listar_vendas`);
                const data = await response.json();
                
                if (data.success) {
                    const tbody = document.getElementById('vendasTable');
                    tbody.innerHTML = '';
                    
                    data.data.forEach(venda => {
                        const tr = document.createElement('tr');
                        const dataFormatada = new Date(venda.data_venda).toLocaleString('pt-BR');
                        tr.innerHTML = `
                            <td>${venda.id_venda}</td>
                            <td>${venda.produto_nome}</td>
                            <td>${venda.quantidade}</td>
                            <td>R$ ${parseFloat(venda.valor_total).toFixed(2)}</td>
                            <td>${dataFormatada}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            } catch (error) {
                console.error('Erro ao carregar vendas:', error);
            }
        }

        // Carregar estatísticas via AJAX
        async function carregarEstatisticas() {
            try {
                const response = await fetch(`${API_URL}?acao=estatisticas`);
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('totalProdutos').textContent = data.data.total_produtos;
                    document.getElementById('totalVendas').textContent = data.data.total_vendas;
                    document.getElementById('valorTotal').textContent = `R$ ${parseFloat(data.data.valor_total_vendido).toFixed(2)}`;
                }
            } catch (error) {
                console.error('Erro ao carregar estatísticas:', error);
            }
        }

        // Formulário de Produto
        document.getElementById('produtoForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = {
                nome: document.getElementById('nome').value,
                descricao: document.getElementById('descricao').value,
                preco: parseFloat(document.getElementById('preco').value),
                quantidade: parseInt(document.getElementById('quantidade').value)
            };

            try {
                const response = await fetch(`${API_URL}?acao=cadastrar_produto`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    mostrarAlerta(data.message, 'success');
                    this.reset();
                    carregarProdutos();
                    carregarEstatisticas();
                } else {
                    mostrarAlerta(data.message, 'error');
                }
            } catch (error) {
                console.error('Erro:', error);
                mostrarAlerta('Erro ao cadastrar produto', 'error');
            }
        });

        // Modal de Venda
        function abrirModalVenda(produtoId, produtoNome, estoque) {
            if (estoque <= 0) {
                mostrarAlerta('Produto sem estoque disponível!', 'error');
                return;
            }
            
            document.getElementById('vendaProdutoId').value = produtoId;
            document.getElementById('vendaProdutoNome').value = produtoNome;
            document.getElementById('vendaEstoqueDisponivel').value = estoque;
            document.getElementById('vendaQuantidade').max = estoque;
            document.getElementById('vendaModal').style.display = 'flex';
        }

        function fecharModal() {
            document.getElementById('vendaModal').style.display = 'none';
            document.getElementById('vendaForm').reset();
        }

        // Formulário de Venda
        document.getElementById('vendaForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = {
                id_produto: parseInt(document.getElementById('vendaProdutoId').value),
                quantidade: parseInt(document.getElementById('vendaQuantidade').value)
            };

            try {
                const response = await fetch(`${API_URL}?acao=registrar_venda`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    mostrarAlerta(data.message, 'success');
                    fecharModal();
                    carregarProdutos();
                    carregarVendas();
                    carregarEstatisticas();
                } else {
                    mostrarAlerta(data.message, 'error');
                }
            } catch (error) {
                console.error('Erro:', error);
                mostrarAlerta('Erro ao registrar venda', 'error');
            }
        });

        // Excluir produto
        async function excluirProduto(produtoId) {
            if (!confirm('Deseja realmente excluir este produto?')) {
                return;
            }

            try {
                const response = await fetch(`${API_URL}?acao=excluir_produto&id=${produtoId}`, {
                    method: 'DELETE'
                });
                
                const data = await response.json();
                
                if (data.success) {
                    mostrarAlerta(data.message, 'success');
                    carregarProdutos();
                    carregarEstatisticas();
                } else {
                    mostrarAlerta(data.message, 'error');
                }
            } catch (error) {
                console.error('Erro:', error);
                mostrarAlerta('Erro ao excluir produto', 'error');
            }
        }

        // Mostrar alertas
        function mostrarAlerta(mensagem, tipo) {
            const alertBox = document.getElementById('alertBox');
            alertBox.textContent = mensagem;
            alertBox.className = `alert alert-${tipo}`;
            alertBox.style.display = 'block';
            
            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 4000);
        }

        // Inicializar sistema ao carregar a página
        document.addEventListener('DOMContentLoaded', init);
    </script>
</body>
</html>