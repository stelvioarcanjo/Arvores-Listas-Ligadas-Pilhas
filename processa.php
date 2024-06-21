<?php
session_start();

include 'estruturas.php';

function obterEstrutura($nome) {
    if (!isset($_SESSION[$nome])) {
        return null;
    }

    $data = $_SESSION[$nome];

    if (is_string($data)) {
        $estrutura = unserialize($data);
        if ($estrutura !== false) {
            return $estrutura;
        }
    }

    return null;
}

function salvarEstrutura($nome, $estrutura) {
    $_SESSION[$nome] = serialize($estrutura);
}

if (obterEstrutura('lista_ligada') === null) {
    $_SESSION['lista_ligada'] = serialize(new ListaLigada());
}

if (obterEstrutura('pilha') === null) {
    $_SESSION['pilha'] = serialize(new Pilha());
}

if (obterEstrutura('arvore_binaria') === null) {
    $_SESSION['arvore_binaria'] = serialize(new ArvoreBinaria());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $estrutura = $_POST['estrutura'] ?? null;
    $valor = $_POST['valor'] ?? null;
    $acao = $_POST['acao'] ?? null;
    $percurso = $_POST['percurso'] ?? null;

    if ($estrutura && $valor !== null && $acao !== 'desempilhar') {
        switch ($estrutura) {
            case 'lista_ligada':
                $listaLigada = obterEstrutura('lista_ligada');
                $listaLigada->inserir($valor);
                salvarEstrutura('lista_ligada', $listaLigada);
                break;
            case 'pilha':
                $pilha = obterEstrutura('pilha');
                $pilha->empilhar($valor);
                salvarEstrutura('pilha', $pilha);
                break;
            case 'arvore_binaria':
                $arvore = obterEstrutura('arvore_binaria');
                $arvore->inserir($valor);
                salvarEstrutura('arvore_binaria', $arvore);
                break;
        }
    } elseif ($estrutura === 'pilha' && $acao === 'desempilhar') {
        $pilha = obterEstrutura('pilha');
        $pilha->desempilhar();
        salvarEstrutura('pilha', $pilha);
    } elseif ($acao === 'visualizar') {
        $listaLigada = obterEstrutura('lista_ligada');
        $pilha = obterEstrutura('pilha');
        $arvore = obterEstrutura('arvore_binaria');

        echo "<h2>Lista Ligada</h2>";
        echo "<p>" . implode(' -> ', $listaLigada->visualizar()) . "</p>";

        echo "<h2>Pilha</h2>";
        echo "<p>" . implode(' ', array_reverse($pilha->visualizar())) . "</p>";

        echo "<h2>Árvore Binária</h2>";
        echo "<p>" . implode(' ', $arvore->visualizar()) . "</p>";

        exit;
    } elseif ($acao === 'visualizar_arvore') {
        $arvore = obterEstrutura('arvore_binaria');
        $valores = [];
        switch ($percurso) {
            case 'pre':
                $arvore->preOrdem($arvore->getRaiz(), $valores);
                break;
            case 'in':
                $arvore->emOrdem($arvore->getRaiz(), $valores);
                break;
            case 'post':
                $arvore->posOrdem($arvore->getRaiz(), $valores);
                break;
        }
        echo json_encode($valores);
        exit;
    }

    header("Location: index.html");
    exit;
}
?>
