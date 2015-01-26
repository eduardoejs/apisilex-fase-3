<?php

namespace EJS\Produtos\Mapper;


use EJS\Database\Conexao;
use EJS\Produtos\Entity\Produto;

class ProdutoMapper {

    public function listProdutos(Conexao $conexao)
    {
        try{
            $conn = $conexao->getDb();
            $list = $conn->prepare("SELECT * FROM  produtos");
            $list->execute();
            $data = $list->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro: ";
            die("{$e->getMessage()}");
        }
        return $data;
    }

    public function listProdutoById($id, Conexao $conexao){
        try{
            $conn = $conexao->getDb();
            $list = $conn->prepare("SELECT * FROM  produtos where id = :id");
            $list->bindValue("id", $id);
            $list->execute();
            $data = $list->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro: ";
            die("{$e->getMessage()}");
        }
        return $data;
    }

    public function insertProduto(Produto $produto, Conexao $conexao){
        try{
            $conn = $conexao->getDb();
            $list = $conn->prepare("Insert into produtos (nome, descricao, valor) values (:nome, :descricao, :valor)");
            $list->bindValue("nome", $produto->getNome());
            $list->bindValue("descricao", $produto->getDescricao());
            $list->bindValue("valor", $produto->getValor());
            $data = $list->execute();
        } catch (PDOException $e) {
            echo "Erro: ";
            die("{$e->getMessage()}");
        }
        return $data;
    }

    public function updateProduto(Produto $produto, Conexao $conexao){
        try{
            $conn = $conexao->getDb();
            $list = $conn->prepare("Update produtos set nome = :nome, descricao = :descricao, valor = :valor where id = :id");
            $list->bindValue("id", $produto->getId());
            $list->bindValue("nome", $produto->getNome());
            $list->bindValue("descricao", $produto->getDescricao());
            $list->bindValue("valor", $produto->getValor());
            $data = $list->execute();
        } catch (PDOException $e) {
            echo "Erro: ";
            die("{$e->getMessage()}");
        }
        return $data;
    }

    public function deleteProduto(Produto $produto, Conexao $conexao){
        try{
            $conn = $conexao->getDb();
            $list = $conn->prepare("Delete from produtos where id = :id");
            $list->bindValue("id", $produto->getId());
            $data = $list->execute();
        } catch (PDOException $e) {
            echo "Erro: ";
            die("{$e->getMessage()}");
        }
        return $data;
    }
} 