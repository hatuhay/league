<?php

namespace Drupal\league_table;

use Drupal\Core\Datetime\DrupalDateTime;

class LeagueTableStorage {

  static function exists($game_id) {
    return (bool) $this->get($game_id);
  }

  static function get($game_id) {
    $result = db_query('SELECT * FROM {league_table} WHERE game_id = :game_id', array(':game_id' => $game_id))->fetchAllAssoc('game_id');
    if ($result) {
      return $result[$game_id];
    }
    else {
      return FALSE;
    }
  }

  static function add($table) {
    db_insert('league_table')->fields(array(
      'game_id' => $table.game_id,
      'team_id' => $table.team_id,
      'local' => $table.local,
      'played' => $table.played,
      'win' => $table.win,
      'tie' => $table.tie,
      'loose' => $table.loose,
      'goals' => $table.goals,
      'favor' => $table.favor,
      'against' => $table.against,
      'points' => $table.points,
      'changed' => $dateTime->getTimestamp();,
      ))->execute();
  }

  static function edit($table) {
    db_update('league_table')->fields(array(
      'game_id' => $table.game_id,
      'team_id' => $table.team_id,
      'local' => $table.local,
      'played' => $table.played,
      'win' => $table.win,
      'tie' => $table.tie,
      'loose' => $table.loose,
      'goals' => $table.goals,
      'favor' => $table.favor,
      'against' => $table.against,
      'points' => $table.points,
      'changed' => $dateTime->getTimestamp();,
    ))
    ->condition('id', $table.id)
    ->execute();
  }
  
  static function delete($id) {
    db_delete('league_table')->condition('id', $id)->execute();
  }

  static function delete_by_game($game_id) {
    $this->delete($id);
  }

}
