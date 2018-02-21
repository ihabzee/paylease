<?php

class Calculator
{
    /**
     * @var array pattern chars
     */
    protected $pattern = [];
    /**
     * @var array
     */
    protected $stack = [];

    /**
     * @var array acceptable operand
     */
    protected $operator = ['+', '-', '*', '/'];

    /**
     * @var array contains performed operations
     */
    public $operations = [];

    /**
     * @param  string $pattern
     * @return array
     * @throws Exception
     */
    public function calculate($pattern)
    {
        //if contains char or special chars
        if (preg_match('/[^0-9\s\+\-\*\/\(\)\.]/', $pattern)) {
            throw new Exception("Pattern `<strong>'.$pattern.'</strong>` contains invalid chars");
        }

        //if less than char with two spaces
        if (strlen($pattern) < 5) {
            throw new Exception('Pattern `<strong>'.$pattern.'</strong>` is too short');
        }

        $this->pattern = explode(' ', trim($pattern));
        foreach ($this->pattern as $key => $char) {

            if (in_array($char, $this->operator)) {
                //recent number
                $num2 = array_pop($this->stack);

                //previous number
                $num1 = array_pop($this->stack);

                //this mean stack still  has operation but no  numbers for it => Invalid
                if ($num2 == null || $num1 == null) {
                    throw new Exception('Pattern `<strong>'.$pattern.'</strong>` is invalid missing numbers to complete the operation');
                }
                $result = $this->performCalc($char, $num1, $num2);
                $this->operations[] = "$num1 $char $num2 = $result";
                array_push($this->stack, $result);
            } else {
                array_push($this->stack, $char);
            }
        }

        //this mean stack still has numbers with no operation for them => Invalid
        if (count($this->stack) > 1) {
            throw new Exception('Pattern `<strong>'.$pattern.'</strong>` is invalid '.(count($this->stack) - 1).' operator/s missing.');
        }
        return $this->stack;
    }

    /**
     * @param string $operand +,-,*,/
     * @param int $num1
     * @param int $num2
     * @return float|int
     * @throws Exception
     */
    protected function performCalc($operand, $num1, $num2)
    {
        switch ($operand) {
            case '+':
                return $num1 + $num2;
                break;
            case '-':
                return $num1 - $num2;
                break;
            case '*':
                return $num1 * $num2;
                break;
            case '/':
                return $num1 / $num2;
                break;
            default:
                throw new Exception('Invalid Operand');
        }
    }
}