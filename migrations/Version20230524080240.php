<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524080240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE controle_bobinage (id INT AUTO_INCREMENT NOT NULL, conformite1 VARCHAR(255) NOT NULL, conformite2 VARCHAR(255) NOT NULL, preconisation1 VARCHAR(255) NOT NULL, preconisation2 VARCHAR(255) NOT NULL, retenu1 VARCHAR(255) NOT NULL, retenu2 VARCHAR(255) NOT NULL, etat TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametre ADD controle_bobinage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC79041C8F48242 FOREIGN KEY (controle_bobinage_id) REFERENCES controle_bobinage (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC79041C8F48242 ON parametre (controle_bobinage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC79041C8F48242');
        $this->addSql('DROP TABLE controle_bobinage');
        $this->addSql('DROP INDEX UNIQ_ACC79041C8F48242 ON parametre');
        $this->addSql('ALTER TABLE parametre DROP controle_bobinage_id');
    }
}
