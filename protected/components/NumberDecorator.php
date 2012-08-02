<?php
class NumberDecorator
{
	public static function decorate($number, $format = "#,###.00")
	{
		$numberFormatter = new CNumberFormatter("pt_BR");
		return $numberFormatter->format($format, $number);
	}
	
	public static function Currency($number)
	{
		$numberFormatter = new CNumberFormatter("pt_BR");
		return $numberFormatter->formatCurrency($number, 'BRL');
	}
	
	public static function removerFormatacaoPTBR($numero)
	{
		return str_replace(",",".", str_replace(".","",str_replace("R$", "", $numero)));
	}
	
	public static function removerFormatacaoUS($numero)
	{
		return str_replace(",", "",str_replace(".", ",",(str_replace("R$", "", $numero))))+0.0;
	}
}