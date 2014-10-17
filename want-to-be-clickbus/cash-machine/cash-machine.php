<?php
class CashMachine
{
	protected static $notas = [50.00, 20.00, 10.00];

	public function __construct($notas = false)
	{
		if($notas && is_array($notas))
		{
			self::$notas = $notas;
		}
	}

	public static function getMoney($value)
	{
		$valor = readline("Informe o valor do saque: ");

		if(!is_numeric($valor) || $valor < 0)
		{
			print "Informe um valor válido!\n\n";
			return $this->getMoney();
		}

		if($valor < min($this->$notas))
		{
			print "O valor solicitado é menor do que o disponível!\n\n";
			return $this->getMoney();
		}

		return $this->calcularNotas($valor);
	}

	protected static function calcularNotas($valor)
	{
		$notas = $this->$notas;
		arsort($notas);
		$valorRestante = $valor;
		$aDispensar = array();
		foreach($notas as $nota) {
			if($valorRestante >= $nota) {
				$quantidadeNota = (int)($valorRestante / $nota);
				$valorRestante -= $quantidadeNota * $nota;
				$aDispensar[] = compact("quantidadeNota", "nota");
			}
		}

		if(empty($aDispensar) || $valorRestante != 0) {
			print "O valor não pode ser processado\n\n";
			return $this->getMoney();
		}

		return $this->dispensarNotas($aDispensar);
	}

	protected static function dispensarNotas($aDispensar)
	{
		var_dump($aDispensar);
	}
}

CashMachine::getMoney();