<?php

namespace EJS\Produtos\Service;

use EJS\Database\Conexao;
use EJS\Produtos\Entity\Produto;
use EJS\Produtos\Mapper\ProdutoMapper;

class ProdutoService {

    private $produto;
    private $produtoMapper;
    private $conexao;

    function __construct(Produto $produto, ProdutoMapper $produtoMapper, Conexao $conexao) {
        $this->produto = $produto;
        $this->produtoMapper = $produtoMapper;
        $this->conexao = $conexao;
    }

    public function listProdutos()
    {
        $produtoMapper = $this->produtoMapper;
        $result = $produtoMapper->listProdutos($this->conexao);

        return $result;
    }

    public function listProdutoById($id){
        return $this->produtoMapper->listProdutoById($id, $this->conexao);
    }

    public function insertProduto($data){
        $this->produto->setNome($data['nome'])
                      ->setDescricao($data['descricao'])
                      ->setValor($data['valor']);

        return $this->produtoMapper->insertProduto($this->produto, $this->conexao);
    }

    public function alterarProduto($data){
        $this->produto->setId($data['id'])
                      ->setNome($data['nome'])
                      ->setDescricao($data['descricao'])
                      ->setValor($data['valor']);
        return $this->produtoMapper->updateProduto($this->produto, $this->conexao);
    }

    public function deleteProduto($data)
    {
        $this->produto->setId($data);
        return $this->produtoMapper->deleteProduto($this->produto, $this->conexao);
    }
} 