<?php

namespace EJS\Produtos\Controller;

use EJS\Produtos\Entity\Produto;
use EJS\Produtos\Mapper\ProdutoMapper;
use EJS\Produtos\Service\ProdutoService;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;


class ProdutoController implements ControllerProviderInterface {

    private $produto;

    public function connect(Application $app)
    {
        $produtoController = $app['controllers_factory'];

        //Rota: index(listagem de produtos)
        $app->get('/', function() use ($app){
            $result = $app['produtoService']->listProdutos();
            return $app['twig']->render('index.twig', ['produtos' => $result]);
        })->bind('index');

        //Rota: listar produto por ID
        $app->get('/produto/view/{id}', function($id) use($app){
            $produto = new Produto();
            $data['nome'] = $produto->getNome();
            $data['descricao'] = $produto->getDescricao();
            $data['valor'] = $produto->getValor();

            $result = $app['produtoService']->listProdutoById($id);

            return $app['twig']->render('visualizar.twig', ['produto' => $result]);
        })->bind('visualizar');

        //Rota para o formulário de insert
        $app->get('/produto/novo', function() use($app){
            return $app['twig']->render('novo.twig',[]);
        })->bind('novo');

        //Rota: após pegar dados do formulário insere no banco de dados
        $app->post('/inserir', function(Request $request) use($app){
            $data = $request->request->all();
            $produto = new Produto();
            $produto->setNome($data['nome']);
            $produto->setValor($data['valor']);

            if($app['produtoService']->insertProduto($data)){
                return $app->redirect($app['url_generator']->generate('index'));
            }else{
                $app->abort(500, "Erro ao cadastrar produto");
            }
        })->bind('inserir');

        //Rota: mensagem de sucesso ao inserir novo registro [utilizar no metodo redirect->generate]
        $app->get('/sucesso', function () use ($app) {
            return $app['twig']->render('sucesso.twig', []);
        })->bind("sucesso");

        //Rota: formulário de alteração
        $app->get('/produto/alterar/{id}', function($id) use($app){
            $produto = new Produto();
            $data['nome'] = $produto->getNome();
            $data['descricao'] = $produto->getDescricao();
            $data['valor'] = $produto->getValor();
            $result = $app['produtoService']->listProdutoById($id);

            return $app['twig']->render('alterar.twig', ['produto' => $result]);
        })->bind('alterar');

        //Rota para alterar registro
        $app->post('/alterar', function(Request $request) use($app){
            $data = $request->request->all();
            $produto = new Produto();
            $produto->setNome($data['nome']);
            $produto->setDescricao($data['descricao']);
            $produto->setValor($data['valor']);

            if($app['produtoService']->alterarProduto($data)){
                return $app->redirect($app['url_generator']->generate('index'));
            }else{
                $app->abort(500, "Erro ao alterar produto");
            }
        })->bind('update');

        //Rota para excluir registro
        $app->get('/produto/delete/{id}', function($id) use($app){
            if($app['produtoService']->deleteProduto($id)){
                return $app->redirect($app['url_generator']->generate('index'));
            }else{
                $app->abort(500, "Erro ao excluir produto");
            }
        })->bind('excluir');

        return $produtoController;
    }
} 