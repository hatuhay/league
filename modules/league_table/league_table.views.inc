<?php

/**
 * @file
 * Gnerate positioning tables via views.
 */


/**
 * Implements hook_views_data()
 */

function league_table_views_data() {
  $data = array();

  $data['league_table']['table']['group'] = t('League Table');

  $data['league_table']['table']['base'] = array(
    'field' => 'id',
    'title' => t('Tables'),
    'help' => t('League Table database table'),
  );
  $data['league_table']['table']['join'] = array(
    'node' => array(
      'handler' => 'views_join', // this is actually optional
      'left_table' => 'league_team', // Because this is a direct link it could be left out.
      'left_field' => 'id',
      'field' => 'team_id',
    ),
    'league_game' => array(
      'handler' => 'views_join', // this is actually optional
      'left_table' => 'league_game', // Because this is a direct link it could be left out.
      'left_field' => 'id',
      'field' => 'game_id',
    ),
  );
  $data['league_table']['id'] = array(
    'title' => t('Table ID'),
    'help' => t('Unique league_table type identifier.'),
    'field' => [
      'id' => 'numeric',
    ],
  );
  $data['league_table']['game_id'] = array(
    'title' => t('Games'),
    'help' => t('The games to calculate table.'),
    'relationship' => array(
        'base' => 'league_game',
        'base field' => 'id',
        'id' => 'standard',
        'label' => t('Game'),
      ),
    'field' => [
      'id' => 'numeric',
    ],
  );
  $data['league_table']['team_id'] = array(
    'title' => t('Team'),
    'help' => t('The teams on the table.'),
    'relationship' => array(
        'base' => 'league_team',
        'base field' => 'id',
        'id' => 'standard',
        'label' => t('Team'),
      ),
    'field' => [
      'id' => 'numeric',
    ],
  );
/*  $data['league_table']['home'] = array(
    'title' => t('Home/away team'),
    'help' => t('If the team was playing home or away.'),
    'field' => [
      'id' => 'home_away',
    ],
    'filter' => array(
      'handler' => 'league_table_handler_filter_home',
    ),
  ); */
  $data['league_table']['played'] = array(
    'title' => t('Match played'),
    'help' => t('If the match was played add one.'),
    'field' => [
      'id' => 'numeric',
    ],
  );
  $data['league_table']['win'] = array(
    'title' => t('Match winned'),
    'help' => t('If the match was winned.'),
    'field' => [
      'id' => 'numeric',
    ],
  );
  $data['league_table']['tie'] = array(
    'title' => t('Match tied'),
    'help' => t('If the match was tie.'),
    'field' => [
      'id' => 'numeric',
    ],
  );
  $data['league_table']['loose'] = array(
    'title' => t('Match loosed'),
    'help' => t('If the match was loosed.'),
    'field' => [
      'id' => 'numeric',
    ],
  );
  $data['league_table']['goals'] = array(
    'title' => t('Goals'),
    'help' => t('Goals in favor minus goals against.'),
    'field' => [
      'id' => 'numeric',
    ],
  );
  $data['league_table']['favor'] = array(
    'title' => t('Goals in favor'),
    'help' => t('Goals scored.'),
    'field' => [
      'id' => 'numeric',
    ],
  );
  $data['league_table']['against'] = array(
    'title' => t('Goals against'),
    'help' => t('Goals scored against.'),
    'field' => [
      'id' => 'numeric',
    ],
  );
  $data['league_table']['points'] = array(
    'title' => t('Points for game'),
    'help' => t('Points this game adds.'),
    'field' => [
      'id' => 'numeric',
    ],
  );
  $data['league_table']['overrited'] = array(
    'title' => t('Overwritten'),
    'help' => t('If is overwritten.'),
    'field' => [
      'id' => 'boolean',
    ],
    'filter' => array(
      'id' => 'boolean',
      'label' => t('Is overrited'),
    ),
  );
  $data['league_table']['modified'] = array(
    'title' => t('Date modified'),
    'help' => t('The date the record was last modified.'),
    'field' => [
      'id' => 'date',
    ],
    'sort' => array(
      'id' => 'date',
    ),
  );
  $data['league_table']['comment'] = array(
    'title' => t('Comment'),
    'help' => t('Comment.'),
    'field' => [
      'id' => 'standard',
    ],
  );

  return $data;
}
