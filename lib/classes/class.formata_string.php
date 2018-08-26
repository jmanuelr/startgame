<?php
/**********************************************************/
/*
  Data de criação : 03/02/2009
  Autor           : Daniel Flores Bastos
  Proposta        : Formatar dados para serem inseridos no Banco de Dados e para a visualização
                  setData     = Envia DATA formatada (aaaa-mm-dd).
                  setCPF      = Envia CPF formatado(###########).
                  setCNPJ     = Envia CNPJ formatado(#############).
                  setCEP      = Envia CEP formatado(########).
                  setTelefone = Envia Telefone formatado(#########).

                  getMoney     = Retorna um VALOR formatado (###.###,##)
                  getToUpper   = Retorna o texto todo em maiúscula(AAAAAAAAAA)
                  getToLower   = Retorna o texto todo em minúscula(aaaaaaaaaa)
                  getSmallText = Retorna um texto até determinado número de caracter
                  getData      = Retorna DATA formatada(dd/mm/aaaa).
                  getCPF       = Retorna CPF formatado(###.###.###-##).
                  getCNPJ      = Retorna CNPJ formatado(##.###.###/####-#).
                  getCEP       = Retorna CEP formatado(#####-###).
                  getTelefone  = Retorna Telefone formatado((##) ####-####).
*/
/**********************************************************/

class FormataString
{

  private $cpf_cnpj;
  private $data;
  private $dataHora;
  private $telefone;
  private $cep;
  private $nr_zero;
  private $zeros;

  function setData($valor)
  {
   if(!empty($valor))
   {
     $this->data = explode('/',$valor);
     $this->data = $this->data[2] . '-' . $this->data[1] . '-' . $this->data[0];
     return $this->data;
   }
  }

  function getData($valor)
  {

    if(!empty($valor))
    {
      $this->data = substr($valor,8,2);
      $this->data .= '/' . substr($valor,5,2);
      $this->data .= '/' . substr($valor,0,4);
      return $this->data;

    }

  }

  function setCPF($valor)
  {

    if(!empty($valor))
    {

      $this->cpf_cnpj = explode('.',$valor);
      $this->cpf_cnpj = $this->cpf_cnpj[0] . $this->cpf_cnpj[1] . $this->cpf_cnpj[2];
      $this->cpf_cnpj = explode('-',$this->cpf_cnpj);
      $this->cpf_cnpj = $this->cpf_cnpj[0] . $this->cpf_cnpj[1];
      if(is_numeric($this->cpf_cnpj) && strlen($this->cpf_cnpj) == 11)
        return $this->cpf_cnpj;
    }

  }

  function setCNPJ($valor)
  {
     $this->cpf_cnpj = explode('.',$valor);
     $this->cpf_cnpj = $this->cpf_cnpj[0] . $this->cpf_cnpj[1] . $this->cpf_cnpj[2];
     $this->cpf_cnpj = explode('/',$this->cpf_cnpj);
     $this->cpf_cnpj = $this->cpf_cnpj[0] . $this->cpf_cnpj[1];
     $this->cpf_cnpj = explode('-',$this->cpf_cnpj);
     $this->cpf_cnpj = $this->cpf_cnpj[0] . $this->cpf_cnpj[1];
     return $this->cpf_cnpj;
  }

  function getCPF($valor)
  {
    if(trim($valor)=="")return "";
    $this->cpf_cnpj = substr($valor,0,3);
    $this->cpf_cnpj .= '.' . substr($valor,3,3);
    $this->cpf_cnpj .= '.' . substr($valor,6,3);
    $this->cpf_cnpj .= '-' . substr($valor,-2);
    return $this->cpf_cnpj;
  }

  function getCNPJ($valor)
  {
    if(trim($valor)=="")return "";
    $this->cpf_cnpj  = substr($valor,0,2);
    $this->cpf_cnpj .= '.' . substr($valor,2,3);
    $this->cpf_cnpj .= '.' . substr($valor,5,3);
    $this->cpf_cnpj .= '/' . substr($valor,8,4);
    $this->cpf_cnpj .= '-' . substr($valor,-2);//-1
    return $this->cpf_cnpj;
  }

  function setTelefone($valor)
  {
    $this->telefone = explode('(',$valor);
    $this->telefone = $this->telefone[0].$this->telefone[1];
    $this->telefone = explode(')',$this->telefone);
    $this->telefone = $this->telefone[0].$this->telefone[1];
    $this->telefone = explode('-',$this->telefone);
    $this->telefone = $this->telefone[0].$this->telefone[1];
    $this->telefone = explode(' ',$this->telefone);
    $this->telefone = $this->telefone[0].$this->telefone[1];
    return $this->telefone;
  }

  function getTelefone($valor)
  {
    $this->telefone  = '(' . substr($valor,0,2) . ') ';
    $this->telefone .= substr($valor,2,4) . '-';
    $this->telefone .= substr($valor,6,8);
    return $this->telefone;
  }

  function setCEP($valor)
  {
    if(!empty($valor))
    {
      $this->cep = explode('-',$valor);
      $this->cep = $this->cep[0] . $this->cep[1];
      return $this->cep;
    }
  }

  function getCEP($valor)
  {
    if(!empty($valor))
    {
      $this->cep  = substr($valor,0,5) . '-';
      $this->cep .= substr($valor,5,3);
      return $this->cep;
    }
  }

  function getSmallText($nr_caracter, $texto)
  {

    if(strlen($texto) > $nr_caracter)
    {
      $_text = substr($texto, 0, ($nr_caracter - 3)) . "...";
    }
    else
    {
      $_text = $texto;
    }

    return $_text;

  }

  function getMoney($valor)
  {
    if(empty($valor))
      $valor = 0;

    return number_format($valor, 2, ',', '.');
  }

  function getToUpper($valor)
  {
    if(!empty($valor))
      $_valor = strtoupper($valor);

    return $_valor;
  }

  function getToLower($valor)
  {
    if(!empty($valor))
      $_valor = strtolower($valor);

    return $_valor;
  }
  //-----
  function getInscricaoEstadual($numero,$estado){
    
    $arr_mascara["RS"] = "###-#######";
    $arr_mascara["SC"] = "###.###.###";
    $arr_mascara["PR"] = "########-##";
    $arr_mascara["SP"] = "###.###.###.###";
    $arr_mascara["MG"] = "###.###.###/####";
    $arr_mascara["RJ"] = "##.###.##-#";
    $arr_mascara["ES"] = "###.###.##-#";
    $arr_mascara["BA"] = "###.###.##-#";
    $arr_mascara["SE"] = "#########-#";
    $arr_mascara["AL"] = "#########";
    $arr_mascara["PE"] = "##.#.###.#######-#";
    $arr_mascara["PA"] = "########-#";
    $arr_mascara["RN"] = "##.###.###-#";
    $arr_mascara["PI"] = "#########";
    $arr_mascara["MA"] = "#########";
    $arr_mascara["CE"] = "########-#";
    $arr_mascara["GO"] = "##.###.###-#";
    $arr_mascara["TO"] = "###########";
    $arr_mascara["MT"] = "#########";
    $arr_mascara["MS"] = "#########";
    $arr_mascara["DF"] = "###########-##";
    $arr_mascara["AM"] = "##.###.###-#";
    $arr_mascara["AC"] = "##.###.###/###-##";
    $arr_mascara["PA"] = "##-######-#";
    $arr_mascara["RO"] = "###.#####-#";
    $arr_mascara["RR"] = "########-#";
    $arr_mascara["AP"] = "#########";

    $str_retorno = "";
    
    $str_retorno = FormataString::getAplicaMascara($numero,$arr_mascara[$estado]);
    
    //retorna o campo formatado
    return $str_retorno;//$mascara;
  }//fnc
  //-----
  function getAplicaMascara($numero,$mascara){
    
    $str_retorno = "";

    if($mascara!=""){
      
      $len_str_mask_full = strlen($mascara);
      $len_str_mask_empty = strlen(eregi_replace("[^\#]","",$mascara));
      $str_aplicar = str_pad($numero,$len_str_mask_empty," ",STR_PAD_LEFT);

      $indice = strlen($str_aplicar);
      
      for ($i=$len_str_mask_full; $i >= 0; $i--) {
        
        $str_aux = $str_aplicar[--$indice];
        
        if( ($mascara[$i]=='#') && is_numeric($str_aux) ){
          
          $str_retorno = $str_aux . $str_retorno;
          
        }else{
          
          if($mascara[$i]!='#'){
            $indice++;
            $str_retorno = $mascara[$i]  . $str_retorno;
          }else{
            
            if(is_numeric($str_aux)){
              $str_retorno = $str_aux  . $str_retorno;
            }else{//caso espaços, ignorar
              //$str_retorno = "($str_aux)"  . $str_retorno;
            }//if
            
          }//if
          
        }//if
      }//for
      
    }//if
    
    //retorna o campo formatado
    return $str_retorno;//$mascara;
  }//fnc
  //-----
}
/*
================================== exemplos:
//Incluir a classe onde estão todos os metodos que serão chamados
03    include_once 'class.FormataString().php';
04   
05    //Instânciando a classe FormataString
06    $formata = new FormataString();
07   
08    $setData     = $formata->setData(date('d/m/Y'));
09    $setCPF      = $formata->setCPF('012.345.678-90');
10    $setCNPJ     = $formata->setCNPJ('11.444.777/0001-61');
11    $setCEP      = $formata->setCEP('01234-567');
12    $setTelefone = $formata->setTelefone('(01) 2345-6789');
13   
14    echo 'Valores que serão inseridos no banco, já formatados:<br />';
15    echo 'Data -     ' . $setData     . '<br />';
16    echo 'CPF -      ' . $setCPF      . '<br />';
17    echo 'CNPJ -     ' . $setCNPJ     . '<br />';
18    echo 'CEP -      ' . $setCEP      . '<br />';
19    echo 'Telefone - ' . $setTelefone . '<br />';
20   
21    $getData      = $formata->getData($setData);
22    $getCPF       = $formata->getCPF($setCPF);
23    $getCNPJ      = $formata->getCNPJ($setCNPJ);
24    $getCEP       = $formata->getCEP($setCEP);
25    $getTelefone  = $formata->getTelefone($setTelefone);
26    $getMoney     = $formata->getMoney('10020050');
27    $getToUpper   = $formata->getToUpper('texto todo em maiúculo');
28    $getToLower   = $formata->getToLower('TEXTO TODO EM MINÚSCULO');
29    $getSmallText = $formata->getSmallText(50, 'Este texto vai conter mais de 50 caracteres, porem a função vai exibir apernas até o 7º caractere e acrescentando ...');
30   
31    echo '<br />Valores que serão retornados no banco, já formatados:<br />';
32    echo 'Data -      ' . $getData      . '<br />';
33    echo 'CPF -       ' . $getCPF       . '<br />';
34    echo 'CNPJ -      ' . $getCNPJ      . '<br />';
35    echo 'CEP -       ' . $getCEP       . '<br />';
36    echo 'Telefone -  ' . $getTelefone  . '<br />';
37    echo 'Money -     ' . $getMoney     . '<br />';
38    echo 'Maiúculo -  ' . $getToUpper   . '<br />';
39    echo 'Minúsculo - ' . $getToLower   . '<br />';
40    echo 'SmallText - ' . $getSmallText . '<br />';
*/
?>