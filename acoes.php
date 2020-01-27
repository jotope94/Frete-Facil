<?php




$passo = (isset($_GET['p']))? $_GET['p'] : "";

switch($passo) {
    
    case "cadastrar_produto":
	{
		 Cadastrar_Produto();
		 break;
	}
	case "mostrar_produto":
	{
		Mostrar_Produtos();
	    break;
	}
	case "cadastrar_pedido":
		{
			Cadastrar_Pedido();
			break;
		}
	case "mostrar_etiquetas":
		{
			Mostrar_Etiquetas();
			break;
		}
		
}



function Cadastrar_Produto()
{
	require("banco.php");
	require("comandos_sql.php");

  
 	$nome = $_POST['nome_produto'];
 	$altura = $_POST['altura_produto'];
    $largura = $_POST['largura_produto'];
    $comprimento = $_POST['comprimento_produto'];
    $peso = $_POST['peso_produto'];

	 If((($altura>=2)&&($altura<=105))||(($largura>=11)&&(largura<=105))||(($comprimento>=16)&&($comprimeto<=105))&&($peso<30))
	 {
	 $resultado=BD_Cadastrar_Produto($conexao,$nome,$altura,$largura,$comprimento,$peso);
	 echo('<div class="alert alert-primary container-fluid quemsomos text-center margin" role="alert">produto cadastrado com sucesso</div>');
	 
	 }
	 else{
		echo('<div class="alert alert-danger container-fluid  text-center margin" role="alert">produto não foi cadastrado, informações invalidas</div>');
	 }
	 require("produto.html");
}

function Mostrar_Produtos()
{
	require("banco.php");
	require("comandos_sql.php");
	$resultado=BD_Mostrar_Produto($conexao);
	require("pedido.html");
	
	echo('<table class="table"');
	echo('<tr>');
	echo("<td>Codigo Produto</td>");
	echo("<td>Nome Produto</td>");
	echo('</tr>');
	echo('</thead>');
	while($aux = mysqli_fetch_assoc($resultado))
	{ 
	  echo('<tr>');
	  echo('<td>'.$aux['codigo'].'</td>');
	  echo('<td>'.$aux['nome'].'</td>');
	  echo('</tr>');
	}
	echo('</table>');
	
}

function Cadastrar_Pedido()
{
	require("banco.php");
	require("comandos_sql.php");

  
 	$produto = $_POST['codigo_produto'];
 	$cep = $_POST['cep_destino'];
	$cep_loja=17519470;
	
	
	 if($cep!=''&& $produto!='')
	 {
		$resultado=BD_Cadastrar_Pedido($conexao,$produto,$cep,$cep_loja);
	  echo('<div class="alert alert-primary container-fluid quemsomos text-center margin" role="alert">pedido cadastrado com sucesso</div>');
	 }
	 else{
		echo('<div class="alert alert-danger container-fluid  text-center margin" role="alert">pedido não foi cadastrado, informações invalidas</div>');
	 }
	 require("pedido.html");
	 
}

function Mostrar_Etiquetas()
{   
	$CdEmpresa='08082650';
    $DsSenha=564321;
	$CepOrigem='05707001';
	$CdFormato=1;
	$CdMaoPropria='n';
	$VlValorDeclarado=0;
	$CdAvisoRecebimento='n';
	$CdServico_pac='04510';
	$CdServico_sedex='04014';
	$Cdfretefacil_pac='04669';
	$Cdfretefacil_sedex='04162';
	$VlDiametro=0;
	$StrRetorno='xml';
	$IndicaCalculo=3;
	$taxa=0.40;
	$taxa_pac=0;
	$taxa_sedex=0;

	require("banco.php");
	require("comandos_sql.php");
	
	$pedidos=BD_Mostrar_Pedidos($conexao);
	
	require("fretefacil.html");
	echo('<table class="table"');
	echo('<tr>');
	echo('<td>Id Pedido</td>');
	echo("<td>Correios Pac</td>");
	echo("<td>Correios Sedex</td>");
	echo("<td>Frete Facil Pac</td>");
	echo("<td>Frete Facil Sedex</td>");
	echo('</tr>');
	while($aux = mysqli_fetch_assoc($pedidos))
	{ 

		$produto=BD_Mostrar_Produto_Pedido($conexao,$aux['fk_produto']);
		$produto_vetor=mysqli_fetch_assoc($produto);

		
		$ff_pac = simplexml_load_file('http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa='.$CdEmpresa.'&sDsSenha='.$DsSenha.'&sCepOrigem='.$CepOrigem.'&sCepDestino='.(string)$aux['cep_destino'].'&nVlPeso='.$produto_vetor['peso'].'&nCdFormato='.$CdFormato.'&nVlComprimento='.$produto_vetor['comprimento'].'&nVlAltura='.$produto_vetor['altura'].'&nVlLargura='.$produto_vetor['largura'].'&sCdMaoPropria='.$CdMaoPropria.'&nVlValorDeclarado='.$VlValorDeclarado.'&sCdAvisoRecebimento='.$CdAvisoRecebimento.'&nCdServico='.$Cdfretefacil_pac.'&nVlDiametro='.$VlDiametro.'&StrRetorno='.$StrRetorno.'&nIndicaCalculo='.$IndicaCalculo);
		$ff_sedex = simplexml_load_file('http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa='.$CdEmpresa.'&sDsSenha='.$DsSenha.'&sCepOrigem='.$CepOrigem.'&sCepDestino='.$aux['cep_destino'].'&nVlPeso='.$produto_vetor['peso'].'&nCdFormato='.$CdFormato.'&nVlComprimento='.$produto_vetor['comprimento'].'&nVlAltura='.$produto_vetor['altura'].'&nVlLargura='.$produto_vetor['largura'].'&sCdMaoPropria='.$CdMaoPropria.'&nVlValorDeclarado='.$VlValorDeclarado.'&sCdAvisoRecebimento='.$CdAvisoRecebimento.'&nCdServico='.$Cdfretefacil_sedex.'&nVlDiametro='.$VlDiametro.'&StrRetorno='.$StrRetorno.'&nIndicaCalculo='.$IndicaCalculo);	
		$pac = simplexml_load_file('http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa='.$CdEmpresa.'&sDsSenha='.$DsSenha.'&sCepOrigem='.$CepOrigem.'&sCepDestino='.$aux['cep_destino'].'&nVlPeso='.$produto_vetor['peso'].'&nCdFormato='.$CdFormato.'&nVlComprimento='.$produto_vetor['comprimento'].'&nVlAltura='.$produto_vetor['altura'].'&nVlLargura='.$produto_vetor['largura'].'&sCdMaoPropria='.$CdMaoPropria.'&nVlValorDeclarado='.$VlValorDeclarado.'&sCdAvisoRecebimento='.$CdAvisoRecebimento.'&nCdServico='.$CdServico_pac.'&nVlDiametro='.$VlDiametro.'&StrRetorno='.$StrRetorno.'&nIndicaCalculo='.$IndicaCalculo);
		$sedex = simplexml_load_file('http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa='.$CdEmpresa.'&sDsSenha='.$DsSenha.'&sCepOrigem='.$CepOrigem.'&sCepDestino='.$aux['cep_destino'].'&nVlPeso='.$produto_vetor['peso'].'&nCdFormato='.$CdFormato.'&nVlComprimento='.$produto_vetor['comprimento'].'&nVlAltura='.$produto_vetor['altura'].'&nVlLargura='.$produto_vetor['largura'].'&sCdMaoPropria='.$CdMaoPropria.'&nVlValorDeclarado='.$VlValorDeclarado.'&sCdAvisoRecebimento='.$CdAvisoRecebimento.'&nCdServico='.$CdServico_sedex.'&nVlDiametro='.$VlDiametro.'&StrRetorno='.$StrRetorno.'&nIndicaCalculo='.$IndicaCalculo);
		echo('<tr>');
		echo("<td>".$aux['codigo'].'</td>');

		foreach($pac->cServico as $cServico)
		{
		
		$val1=$cServico->Valor;
		}
		echo("<td>".$val1.'</td>');
		
		foreach($sedex->cServico as $cServico)
		{
		$val2=$cServico->Valor;
		}
		echo("<td>".$val2.'</td>');
	

		foreach($ff_pac->cServico as $cServico)
		{
			$val3=$cServico->Valor;
		}
		
		$taxa_pac=($val1-$val3)*$taxa;
		$val3=str_replace(",", ".", $val3)+$taxa_pac;
		echo("<td>".$val3.'</td>');
		foreach($ff_sedex->cServico as $cServico)
		{
		$val4=$cServico->Valor;
		}

		$taxa_sedex=($val2-$val4)*$taxa;
		$val4=str_replace(",", ".", $val4)+$taxa_sedex;
	    echo("<td>".$val4.'</td>');

	}
	echo('</table>');
		
	
}

