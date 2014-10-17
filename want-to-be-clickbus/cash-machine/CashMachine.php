<?php
class CashMachine
{
	protected static $notes = [50.00, 20.00, 10.00];

	public function __construct($notes = false)
	{
		if($notes && is_array($notes))
		{
			self::$notes = $notes;
		}
	}

	public function getCash($value)
	{
		if(is_null($value)) {
			return;
		}

		if(!is_numeric($value) || $value < 0)
		{
			throw new InvalidArgumentException('Argumento inválido');
		}

		if($value < min(self::$notes))
		{
			throw new NoteUnavailableException("O valor solicitado é menor do que o disponível na maquina!\n\n");
		}

		return $this->dispenseNotes($value);
	}

	protected function calculateNotes($value)
	{
		$notes = self::$notes;
		arsort($notes);
		$rest = $value;
		$notesToDispense = array();
		foreach($notes as $note) {
			if($rest >= $note) {
				$count = (int)($rest / $note);
				$rest -= $count * $note;
				$notesToDispense[] = compact("count", "note");
			}
		}

		if(empty($notesToDispense) || $rest != 0) {
			throw new NoteUnavailableException("O valor não pode ser processado");
		}

		return $notesToDispense;
	}

	protected function dispenseNotes($values)
	{
		$notes = $this->calculateNotes($values);
		$notesToDispense = array();
		foreach($notes as $note)
		{
			//Muito feio isso
			for($a = 0; $a < $note['count']; $a ++)
			{
				$notesToDispense[] = $note['note'];
			}
		}
		return $notesToDispense;
	}
}