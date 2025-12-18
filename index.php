<?php
$resultado = '';
$num1 = '';
$num2 = '';
$operacao = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $num1 = isset($_POST['num1']) ? floatval($_POST['num1']) : 0;
    $num2 = isset($_POST['num2']) ? floatval($_POST['num2']) : 0;
    $operacao = $_POST['operacao'] ?? '';
    
    switch ($operacao) {
        case 'somar':
            $resultado = $num1 + $num2;
            break;
        case 'subtrair':
            $resultado = $num1 - $num2;
            break;
        case 'multiplicar':
            $resultado = $num1 * $num2;
            break;
        case 'dividir':
            if ($num2 != 0) {
                $resultado = $num1 / $num2;
            } else {
                $resultado = 'Erro: Divisão por zero!';
            }
            break;
        case 'potencia':
            $resultado = pow($num1, $num2);
            break;
        case 'raiz':
            if ($num1 >= 0) {
                $resultado = sqrt($num1);
            } else {
                $resultado = 'Erro: Raiz de número negativo!';
            }
            break;
        default:
            $resultado = 'Operação inválida!';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora PHP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .calculator {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            padding: 30px;
        }
        
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
            font-size: 2.2em;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        
        input, select {
            width: 100%;
            padding: 14px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        input:focus, select:focus {
            border-color: #2575fc;
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 117, 252, 0.1);
        }
        
        .btn-group {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 25px;
        }
        
        button {
            background: linear-gradient(to right, #2575fc, #6a11cb);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 14px rgba(0, 0, 0, 0.15);
        }
        
        button[type="reset"] {
            background: linear-gradient(to right, #f46b45, #eea849);
        }
        
        button[type="reset"]:hover {
            background: linear-gradient(to right, #e55a37, #e89c42);
        }
        
        .result {
            margin-top: 25px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 5px solid #2575fc;
        }
        
        .result h3 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .result-value {
            font-size: 2em;
            font-weight: 700;
            color: #2575fc;
            word-break: break-all;
        }
        
        .operation-info {
            font-size: 0.9em;
            color: #666;
            margin-top: 5px;
        }
        
        @media (max-width: 480px) {
            .calculator {
                padding: 20px;
            }
            
            .btn-group {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="calculator">
        <h1>📟 Calculadora Interativa</h1>
        
        <form method="post">
            <div class="form-group">
                <label for="num1">Primeiro Número:</label>
                <input type="number" step="any" id="num1" name="num1" value="<?php echo htmlspecialchars($num1); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="operacao">Operação:</label>
                <select id="operacao" name="operacao" required>
                    <option value="">Selecione uma operação</option>
                    <option value="somar" <?php echo ($operacao == 'somar') ? 'selected' : ''; ?>>Adição (+)</option>
                    <option value="subtrair" <?php echo ($operacao == 'subtrair') ? 'selected' : ''; ?>>Subtração (-)</option>
                    <option value="multiplicar" <?php echo ($operacao == 'multiplicar') ? 'selected' : ''; ?>>Multiplicação (×)</option>
                    <option value="dividir" <?php echo ($operacao == 'dividir') ? 'selected' : ''; ?>>Divisão (÷)</option>
                    <option value="potencia" <?php echo ($operacao == 'potencia') ? 'selected' : ''; ?>>Potência (xʸ)</option>
                    <option value="raiz" <?php echo ($operacao == 'raiz') ? 'selected' : ''; ?>>Raiz Quadrada (√)</option>
                </select>
            </div>
            
            <div class="form-group" id="num2-group">
                <label for="num2">Segundo Número:</label>
                <input type="number" step="any" id="num2" name="num2" value="<?php echo htmlspecialchars($num2); ?>" required>
            </div>
            
            <div class="btn-group">
                <button type="submit">Calcular</button>
                <button type="reset" onclick="limparResultado()">Limpar</button>
            </div>
        </form>
        
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && $resultado !== ''): ?>
        <div class="result">
            <h3>Resultado:</h3>
            <div class="result-value">
                <?php 
                if (is_numeric($resultado)) {
                    echo number_format($resultado, 4, ',', '.');
                } else {
                    echo $resultado;
                }
                ?>
            </div>
            <div class="operation-info">
                <?php
                $operacoes_texto = [
                    'somar' => 'Adição',
                    'subtrair' => 'Subtração',
                    'multiplicar' => 'Multiplicação',
                    'dividir' => 'Divisão',
                    'potencia' => 'Potência',
                    'raiz' => 'Raiz Quadrada'
                ];
                
                if ($operacao == 'raiz') {
                    echo $operacoes_texto[$operacao] . " de " . htmlspecialchars($num1);
                } else {
                    echo $operacoes_texto[$operacao] . ": " . htmlspecialchars($num1) . " e " . htmlspecialchars($num2);
                }
                ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <script>
        // Mostra/oculta o segundo número baseado na operação selecionada
        const operacaoSelect = document.getElementById('operacao');
        const num2Group = document.getElementById('num2-group');
        const num2Input = document.getElementById('num2');
        
        operacaoSelect.addEventListener('change', function() {
            if (this.value === 'raiz') {
                num2Group.style.display = 'none';
                num2Input.removeAttribute('required');
            } else {
                num2Group.style.display = 'block';
                num2Input.setAttribute('required', 'required');
            }
        });
        
        // Inicializa a visibilidade do campo num2
        if (operacaoSelect.value === 'raiz') {
            num2Group.style.display = 'none';
            num2Input.removeAttribute('required');
        }
        
        // Função para limpar completamente o formulário e resultado
        function limparResultado() {
            document.querySelector('form').reset();
            const resultDiv = document.querySelector('.result');
            if (resultDiv) {
                resultDiv.style.display = 'none';
            }
            num2Group.style.display = 'block';
            num2Input.setAttribute('required', 'required');
        }
    </script>
</body>
</html>
