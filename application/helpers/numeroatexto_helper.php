<?php

/**
 * Convierte un número en una cadena de letras, para el idioma
 * castellano, pero puede funcionar para español de mexico, de  
 * españa, colombia, argentina, etc.
 * 
 * Máxima cifra soportada: 18 dígitos con 2 decimales
 * 999,999,999,999,999,999.99
 * NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE BILLONES
 * NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE MILLONES
 * NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE PESOS 99/100 M.N.
 * 
 * @author Ultiminio Ramos Galán <contacto@ultiminioramos.com>
 * @param string $numero La cantidad numérica a convertir 
 * @param string $moneda La moneda local de tu país
 * @param string $subfijo Una cadena adicional para el subfijo
 * 
 * @return string La cantidad convertida a letras
 */

function floordec($zahl, $decimals = 1)
{
    $numero = "";
    if (is_float($zahl)) {
        $numero =  floor($zahl * pow(10, $decimals)) / pow(10, $decimals);
    } else {
        $numero = $zahl;
    }
    return $numero;
}

function eliminarDecimalCero($zahl, $decimals = 1)
{
    $numero = "";
    if (is_float($zahl)) {
        $numpart = explode(".", $zahl);
        if ((isset($numpart[1])) && ($numpart[1] > 0)) {
            $numero =  floor($zahl * pow(10, $decimals)) / pow(10, $decimals);
        } else {
            if (isset($numpart[0]) && $numpart[0] == 10) {
                $numero = $numpart[0];
            } else {
                $numero = floor($zahl * pow(10, $decimals)) / pow(10, $decimals);
            }
        }
    } else {
        $numpart = explode(".", $zahl);
        if ((isset($numpart[1])) && ($numpart[1] > 0)) {
            if (isset($numpart[0]) && $numpart[0] == 10) {
                $numero = $numpart[0];
            } else {
                $numero =  floor($zahl * pow(10, $decimals)) / pow(10, $decimals);
            }
        } else {
            if (isset($numpart[0]) && $numpart[0] == 10) {
                $numero = $numpart[0];
            } else {
                if ((isset($numpart[1])) && ($numpart[1] > 0)) {
                    $numero =  floor($zahl * pow(10, $decimals)) / pow(10, $decimals);
                } else {
                    $numero =  number_format($zahl, 1);
                }
            }
        }
    }
    return $numero;
}
function mostrarReprovado($idnivel, $niveleducativo, $total_materia, $total_aprovado, $total_reprovado, $reprobado_permitido, $calificacion_optenida, $calificacion_minima)
{
    $mensaje = false;
    if ($niveleducativo == 1) {
        // PRIMARIA
        if ($idnivel == 1) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 2) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 3) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 4) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 5) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 6) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
    }
    if ($niveleducativo == 2) {
        // SECUANDARIA
        if ($idnivel == 1) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
            /*
             * elseif ($calificacion_optenida >= $calificacion_minima) {
             *
             * $mensaje = false;
             * } else {
             * $mensaje = false;
             * }
             */
        }
        if ($idnivel == 2) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 3) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 4) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 5) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 6) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
    }
    if ($niveleducativo == 3) {
        // PREPARATORIA
        if ($idnivel == 1) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 2) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 3) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 4) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = false;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 5) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = false;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 6) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = false;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
    }

    if ($niveleducativo == 5) {
        // LICENCIATURA
        if ($idnivel == 1) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 2) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 3) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 4) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 5) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 6) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 7) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
        if ($idnivel == 8) {
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje = true;
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje = true;
                } else {
                    $mensaje = false;
                }
            }
        }
    }

    return $mensaje;
}
function calcularReprovado($idnivel, $niveleducativo, $total_materia, $total_aprovado, $total_reprovado, $reprobado_permitido, $calificacion_optenida, $calificacion_minima)
{
    $mensaje = "";
    if ($niveleducativo == 1) {
        //PRIMARIA
        if ($idnivel == 1) {
            //PRIMER AÑO
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 2) {
            //SEGUNDO AÑO
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 3) {
            //TERCER AÑO
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 4) {
            //CUARTO AÑO
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 5) {
            //QUINTO AÑO
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 6) {
            //SEXO AÑO
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
    }
    if ($niveleducativo == 2) {
        //SECUANDARIA

        if ($idnivel == 1) {
            //PRIMER  SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 2) {
            //SEGUNDO SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 3) {
            //TERCER SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 4) {
            //CUARTO SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 5) {
            //QUINTO SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 6) {
            //SEXO SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
    }
    if ($niveleducativo == 3) {
        //PREPARATORIA
        if ($idnivel == 1) {
            //PRIMER  SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 2) {
            //SEGUNDO SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 3) {
            //TERCER SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 4) {
            //CUARTO SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 5) {
            //QUINTO SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 6) {
            //SEXO SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
    }
    if ($niveleducativo == 5) {
        //PREPARATORIA
        if ($idnivel == 1) {
            //PRIMER  SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 2) {
            //SEGUNDO SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 3) {
            //TERCER SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 4) {
            //CUARTO SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 5) {
            //QUINTO SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 6) {
            //SEXO SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 7) {
            //SEPTIMO SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
        if ($idnivel == 8) {
            //OCTAVO SEMESTRE
            if ($total_reprovado > $reprobado_permitido) {
                $mensaje .= "<label style='color:red; font-size: 16px;'>REPROBADO</label>";
            } elseif ($calificacion_optenida >= $calificacion_minima) {
                if ($total_reprovado > 0) {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label> <small style='color:red;'> Pero tiene materias pendiente por recuperar.</small>";
                } else {
                    $mensaje .= "<label style='color:green; font-size: 16px;'>APROBADO</label>";
                }
            }
        }
    }
    return $mensaje;
}
function validar_calificacion($calificacion, $calificacion_aprovatoria)
{
    if ($calificacion < $calificacion_aprovatoria) {
        return true;
    } else {
        return false;
    }
}
function cutNum($num, $precision = 2)
{
    return floor($num) . substr(str_replace(floor($num), '', $num), 0, $precision + 1);
}
function numberFormatPrecision($number, $precision = 2, $separator = '.')
{
    $numberParts = explode($separator, $number);
    $response = $numberParts[0];
    if (count($numberParts) > 1) {
        $response .= $separator;
        $response .= substr($numberParts[1], 0, $precision);
    }
    return $response;
}
function obtenerPorcentaje($cantidad, $total)
{
    $porcentaje = ((float)$cantidad * 100) / $total; // Regla de tres
    $porcentaje = round($porcentaje, 0);  // Quitar los decimales
    return $porcentaje;
}
function dias_pasados($fecha_inicial, $fecha_fin)
{
    $dias = (strtotime($fecha_fin) - strtotime($fecha_inicial)) / 86400;
    $dias = abs($dias);
    $dias = floor($dias);
    return $dias;
}

function num_to_letras($numero, $moneda = 'PESO', $subfijo = 'M.N.')
{
    $xarray = array(
        0 => 'Cero', 1 => 'UN', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE', 'DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE', 'VEINTI', 30 => 'TREINTA', 40 => 'CUARENTA', 50 => 'CINCUENTA', 60 => 'SESENTA', 70 => 'SETENTA', 80 => 'OCHENTA', 90 => 'NOVENTA', 100 => 'CIENTO', 200 => 'DOSCIENTOS', 300 => 'TRESCIENTOS', 400 => 'CUATROCIENTOS', 500 => 'QUINIENTOS', 600 => 'SEISCIENTOS', 700 => 'SETECIENTOS', 800 => 'OCHOCIENTOS', 900 => 'NOVECIENTOS'
    );

    $numero = trim($numero);
    $xpos_punto = strpos($numero, '.');
    $xaux_int = $numero;
    $xdecimales = '00';
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $numero = '0' . $numero;
            $xpos_punto = strpos($numero, '.');
        }
        $xaux_int = substr($numero, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($numero . '00', $xpos_punto + 1, 2); // obtengo los valores decimales
    }

    $XAUX = str_pad($xaux_int, 18, ' ', STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = '';
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        $key = (int) substr($xaux, 0, 3);
                        if (100 > $key) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                            /* do nothing */
                        } else {
                            if (TRUE === array_key_exists($key, $xarray)) {  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                if (100 == $key) {
                                    $xcadena = ' ' . $xcadena . ' CIEN ' . $xsub;
                                } else {
                                    $xcadena = ' ' . $xcadena . ' ' . $xseek . ' ' . $xsub;
                                }
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            } else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = ' ' . $xcadena . ' ' . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        $key = (int) substr($xaux, 1, 2);
                        if (10 > $key) {
                            /* do nothing */
                        } else {
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux);
                                if (20 == $key) {
                                    $xcadena = ' ' . $xcadena . ' VEINTE ' . $xsub;
                                } else {
                                    $xcadena = ' ' . $xcadena . ' ' . $xseek . ' ' . $xsub;
                                }
                                $xy = 3;
                            } else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == $key)
                                    $xcadena = ' ' . $xcadena . ' ' . $xseek;
                                else
                                    $xcadena = ' ' . $xcadena . ' ' . $xseek . ' Y ';
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        $key = (int) substr($xaux, 2, 1);
                        if (1 > $key) { // si la unidad es cero, ya no hace nada
                            /* do nothing */
                        } else {
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = subfijo($xaux);
                            $xcadena = ' ' . $xcadena . ' ' . $xseek . ' ' . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO
        # si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
        if ('ILLON' == substr(trim($xcadena), -5, 5)) {
            $xcadena .= ' DE';
        }

        # si la cadena obtenida en MILLONES o BILLONES, entonces le agrega al final la conjuncion DE
        if ('ILLONES' == substr(trim($xcadena), -7, 7)) {
            $xcadena .= ' DE';
        }

        # depurar leyendas finales
        if ('' != trim($xaux)) {
            switch ($xz) {
                case 0:
                    if ('1' == trim(substr($XAUX, $xz * 6, 6))) {
                        $xcadena .= 'UN BILLON ';
                    } else {
                        $xcadena .= ' BILLONES ';
                    }
                    break;
                case 1:
                    if ('1' == trim(substr($XAUX, $xz * 6, 6))) {
                        $xcadena .= 'UN MILLON ';
                    } else {
                        $xcadena .= ' MILLONES ';
                    }
                    break;
                case 2:
                    if (1 > $numero) {
                        $xcadena = "CERO {$moneda}S {$xdecimales}/100 {$subfijo}";
                    }
                    if ($numero >= 1 && $numero < 2) {
                        $xcadena = "UN {$moneda} {$xdecimales}/100 {$subfijo}";
                    }
                    if ($numero >= 2) {
                        $xcadena .= " {$moneda}S {$xdecimales}/100 {$subfijo}"; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")

        $xcadena = str_replace('VEINTI ', 'VEINTI', $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace('  ', ' ', $xcadena); // quito espacios dobles
        $xcadena = str_replace('UN UN', 'UN', $xcadena); // quito la duplicidad
        $xcadena = str_replace('  ', ' ', $xcadena); // quito espacios dobles
        $xcadena = str_replace('BILLON DE MILLONES', 'BILLON DE', $xcadena); // corrigo la leyenda
        $xcadena = str_replace('BILLONES DE MILLONES', 'BILLONES DE', $xcadena); // corrigo la leyenda
        $xcadena = str_replace('DE UN', 'UN', $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}

/**
 * Esta función regresa un subfijo para la cifra
 * 
 * @author Ultiminio Ramos Galán <contacto@ultiminioramos.com>
 * @param string $cifras La cifra a medir su longitud
 */
function subfijo($cifras)
{
    $cifras = trim($cifras);
    $strlen = strlen($cifras);
    $_sub = '';
    if (4 <= $strlen && 6 >= $strlen) {
        $_sub = 'MIL';
    }

    return $_sub;
}

/*  EOF  */


function generateRandomString($length = 10)
{
    return substr(str_shuffle("0123456789"), 0, $length);
}
