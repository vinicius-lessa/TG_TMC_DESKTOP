<?php
/* 
4 SEMESTRE - SISTEMAS PARA INTERNET
Author: Vinícius Lessa da Silva / Anderson Nascimento
Since: 2020/06/19
*/
/* FUNÇÃO PARA VALIDAR O CLIENTE NO BANCO */
function consultarCliente($user, $conn)
{
    $sql = 'SELECT cod_cliente, nome_cliente, telefone, cpf, email, senha  from cliente where cod_cliente = ? ';
    $stmt = $conn->prepare($sql) ;
    $stmt->bind_param("i", $user);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_assoc();

    $stmt->close();

    return $result;
}

/* FUNÇÃO PARA ALTERAR OS CLIENTES NO BANCO */
function alterarCliente($dados, $conn)
{
    $sql = 'UPDATE cliente SET nome_cliente =?, telefone =?, email=? WHERE cod_cliente =?';
    $stmt = $conn->prepare($sql) ;
    $stmt->bind_param("sssi", $dados['nome_cliente'], $dados['telefone'], $dados['email'], $dados['cod_cliente']);

    $result = $stmt->execute() ? true : false;
    $stmt->close();
    return $result;
}

/* FUNÇÃO PARA EXCLUIR OS CLIENTES NO BANCO */
function excluirCliente($dados, $conn)
{
    // Comentários
    $sql    = 'DELETE FROM comentario WHERE cod_cliente =?';
    $stmt   = $conn->prepare($sql) ;
    $stmt->bind_param("i", $dados);
    $stmt->execute();

    // Pedidos
    $sql    = 'DELETE FROM pedido WHERE cod_cliente =?';
    $stmt   = $conn->prepare($sql) ;
    $stmt->bind_param("i", $dados);
    $stmt->execute();
    
    // Clientes
    $sql    = 'DELETE FROM cliente WHERE cod_cliente =?';
    $stmt   = $conn->prepare($sql) ;
    $stmt->bind_param("i", $dados);
    $result = $stmt->execute() ? true : false;
    $stmt->close();

    return $result;
}
