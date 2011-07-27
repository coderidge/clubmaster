<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20110726151702 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("DROP TABLE club_message_message_location");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("CREATE TABLE club_message_message_location (message_id INT NOT NULL, location_id INT NOT NULL, INDEX IDX_EEBD94BC537A1329 (message_id), INDEX IDX_EEBD94BC64D218E (location_id), PRIMARY KEY(message_id, location_id)) ENGINE = InnoDB");
        $this->addSql("ALTER TABLE club_message_message_location ADD CONSTRAINT club_message_message_location_ibfk_2 FOREIGN KEY (location_id) REFERENCES club_user_location(id)");
        $this->addSql("ALTER TABLE club_message_message_location ADD CONSTRAINT club_message_message_location_ibfk_1 FOREIGN KEY (message_id) REFERENCES club_message_message(id)");
    }
}