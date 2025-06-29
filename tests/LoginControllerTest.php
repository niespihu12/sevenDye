<?php

use PHPUnit\Framework\TestCase;
use Model\Usuario;

class LoginControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $reflection = new \ReflectionClass(Usuario::class);
        $alertasProperty = $reflection->getProperty('alertas');
        $alertasProperty->setAccessible(true);
        $alertasProperty->setValue(['error' => []]);
    }

    public function testValidarLoginConEmailVacio()
    {
        $usuario = new Usuario();
        $usuario->contraseña = 'password123';
        $alertas = $usuario->validarLogin();
        $this->assertContains('El email es obligatorio', $alertas['error']);
    }

    public function testValidarLoginConPasswordVacio()
    {
        $usuario = new Usuario();
        $usuario->email = 'correo@correo.com';
        $alertas = $usuario->validarLogin();
        $this->assertContains('El password es obligatorio', $alertas['error']);
    }

    public function testValidarLoginConCamposValidos()
    {
        $usuario = new Usuario(['email' => 'correo@correo.com', 'contraseña' => '12345678']);
        $alertas = $usuario->validarLogin();
        $this->assertEmpty($alertas['error']);
    }

    public function testComprobarPasswordConCredencialesCorrectas()
    {
        $hash = password_hash('12345678', PASSWORD_BCRYPT);
        $usuario = new Usuario([
            'contraseña' => $hash,
            'confirmado' => 1
        ]);
        $resultado = $usuario->comprobarPasswordAndVerificado('12345678');
        $this->assertTrue($resultado);
    }

    public function testComprobarPasswordConPasswordIncorrecto()
    {
        $hash = password_hash('password123', PASSWORD_BCRYPT);
        $usuario = new Usuario([
            'contraseña' => $hash,
            'confirmado' => 1
        ]);
        $resultado = $usuario->comprobarPasswordAndVerificado('incorrecto');

        $alertas = $this->getAlertasStatic();
        $this->assertContains('Password Incorrecto o tu cuenta no ha sido confirmada', $alertas['error']);
    }

   

    private function getAlertasStatic()
    {
        $reflection = new \ReflectionClass(Usuario::class);
        $alertasProperty = $reflection->getProperty('alertas');
        $alertasProperty->setAccessible(true);
        return $alertasProperty->getValue();
    }
}