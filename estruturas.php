<?php

class No {
    public $valor;
    public $proximo;

    public function __construct($valor) {
        $this->valor = $valor;
        $this->proximo = null;
    }
}

class ListaLigada {
    private $cabeca;

    public function __construct() {
        $this->cabeca = null;
    }

    public function inserir($valor) {
        $novoNo = new No($valor);
        if ($this->cabeca === null) {
            $this->cabeca = $novoNo;
        } else {
            $atual = $this->cabeca;
            while ($atual->proximo !== null) {
                $atual = $atual->proximo;
            }
            $atual->proximo = $novoNo;
        }
    }

    public function visualizar() {
        $valores = [];
        $atual = $this->cabeca;
        while ($atual !== null) {
            $valores[] = $atual->valor;
            $atual = $atual->proximo;
        }
        return $valores;
    }
}

class Pilha {
    private $elementos;

    public function __construct() {
        $this->elementos = [];
    }

    public function empilhar($valor) {
        array_push($this->elementos, $valor);
    }

    public function desempilhar() {
        return array_pop($this->elementos);
    }

    public function visualizar() {
        return $this->elementos;
    }
}

class NoArvore {
    public $valor;
    public $esquerda;
    public $direita;

    public function __construct($valor) {
        $this->valor = $valor;
        $this->esquerda = null;
        $this->direita = null;
    }
}

class ArvoreBinaria {
    private $raiz;

    public function __construct() {
        $this->raiz = null;
    }

    public function inserir($valor) {
        $novoNo = new NoArvore($valor);
        if ($this->raiz === null) {
            $this->raiz = $novoNo;
        } else {
            $this->inserirRecursivo($this->raiz, $novoNo);
        }
    }

    private function inserirRecursivo($no, $novoNo) {
        if ($novoNo->valor < $no->valor) {
            if ($no->esquerda === null) {
                $no->esquerda = $novoNo;
            } else {
                $this->inserirRecursivo($no->esquerda, $novoNo);
            }
        } else {
            if ($no->direita === null) {
                $no->direita = $novoNo;
            } else {
                $this->inserirRecursivo($no->direita, $novoNo);
            }
        }
    }

    public function visualizar() {
        $valores = [];
        $this->preOrdem($this->raiz, $valores);
        return $valores;
    }

    public function preOrdem($no, &$valores) {
        if ($no !== null) {
            $valores[] = $no->valor;
            $this->preOrdem($no->esquerda, $valores);
            $this->preOrdem($no->direita, $valores);
        }
    }

    public function emOrdem($no, &$valores) {
        if ($no !== null) {
            $this->emOrdem($no->esquerda, $valores);
            $valores[] = $no->valor;
            $this->emOrdem($no->direita, $valores);
        }
    }

    public function posOrdem($no, &$valores) {
        if ($no !== null) {
            $this->posOrdem($no->esquerda, $valores);
            $this->posOrdem($no->direita, $valores);
            $valores[] = $no->valor;
        }
    }

    public function getRaiz() {
        return $this->raiz;
    }
}


?>
