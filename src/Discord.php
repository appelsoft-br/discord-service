<?php

namespace Appelsoft\Discord;

class Discord
{

  static function notificarCanal(string $webhook, string $produto, $mensagem, $snJson)
  {
    if ($snJson) {
      is_string($mensagem) && $mensagem = json_decode($mensagem);
      $mensagem =  '```json' . PHP_EOL . json_encode($mensagem, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL . '```';
    }
    $json_data = json_encode([
      "content" => $produto . " - " . $mensagem,
      "tts" => false,


    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    $ch = curl_init($webhook);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    try {
      curl_exec($ch);
    } catch (\Throwable $th) {
    }

    curl_close($ch);
  }

  static function notificarCanalFalhas(string $produto, $mensagem, $snJson = false)
  {
    self::notificarCanal(getenv('CANAL_DISCORD_FALHAS'), $produto, $mensagem, $snJson);
  }

  static function notificarCanalClientes(
    string $produto,
    $mensagem,
    $snJson = false
  ) {
    self::notificarCanal(getenv('CANAL_DISCORD_CLIENTES'), $produto, $mensagem, $snJson);
  }

  static function notificarCanalPagamentos(string $produto,  $mensagem, $snJson = false)
  {
    self::notificarCanal(getenv('CANAL_DISCORD_PAGAMENTOS'), $produto, $mensagem, $snJson);
  }

  static function notificarCanalDebug(string $produto,  $mensagem, $snJson = false)
  {
    self::notificarCanal(getenv('CANAL_DISCORD_DEBUG'), $produto, $mensagem, $snJson);
  }
  static function notificarCanalRelease(string $produto,  $mensagem, $snJson = false)
  {
    self::notificarCanal(getenv('CANAL_DISCORD_RELEASES'), $produto, $mensagem, $snJson);
  }
}
