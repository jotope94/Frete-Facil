<?php

function BD_Cadastrar_Produto( $conexao,$nome,$altura,$largura,$comprimento,$peso)
{
	
	$sql = sprintf("INSERT INTO produtos(nome,altura,largura,comprimento,peso) VALUES ('%s', %f,%f,%f,%f)",$nome,$altura,$largura,$comprimento,$peso );
	
	
	$resultado = mysqli_query($conexao, $sql) or die( mysqli_error($conexao) );
	
	return $resultado;
}	

function BD_Mostrar_Produto( $conexao)
{
	
	$sql = sprintf("select codigo,nome from produtos");
	
	
	$resultado = mysqli_query($conexao, $sql) or die( mysqli_error($conexao) );
	
	return $resultado;
}	

function BD_Cadastrar_Pedido( $conexao,$produto,$cep_destino,$cep_origem)
{
	
	$sql = sprintf("INSERT INTO pedidos	(cep_destino,cep_origem,fk_produto) VALUES ('%f',%d,%d)",$cep_destino,$cep_origem,$produto);
	
	
	$resultado = mysqli_query($conexao, $sql) or die( mysqli_error($conexao) );
	
	return $resultado;
}	

function BD_Mostrar_Pedidos( $conexao)
{
	
	$sql = sprintf("select * from pedidos");
	
	
	$resultado = mysqli_query($conexao, $sql) or die( mysqli_error($conexao) );
	
	return $resultado;
}	

function BD_Mostrar_Produto_Pedido( $conexao,$fk_produto)
{
	
	$sql = sprintf("select * from produtos where codigo=%d",$fk_produto);
	
	
	$resultado = mysqli_query($conexao, $sql) or die( mysqli_error($conexao) );
	
	return $resultado;
}	