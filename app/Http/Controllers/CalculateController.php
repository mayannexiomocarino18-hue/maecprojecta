<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculateController extends Controller
{
    function add() {
    $n1 = 2;
    $n2 = 3;
    $sum = $n1 + $n2;
    return "The sum is: " .$sum;
    }

    function subtract() {
    $n1 = 2;
    $n2 = 3;
    $subtract = $n1 - $n2;
    return "The difference is: " .$subtract;
    }

    function divide() {
    $n1 = 2;
    $n2 = 3;
    $divide = $n1 / $n2;
    return "The qoutient is: " .$divide;
    }

    function multiply() {
    $n1 = 2;
    $n2 = 3;
    $multiply = $n1 * $n2;
    return "The product is: " .$multiply;
    }

    function modulo() {
    $n1 = 2;
    $n2 = 3;
    $modulo = $n1 % $n2;
    return "The remainder is: " .$modulo;
    }
}
