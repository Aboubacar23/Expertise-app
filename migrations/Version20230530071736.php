<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230530071736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE constat_electrique (id INT AUTO_INCREMENT NOT NULL, parametre_id INT DEFAULT NULL, verification VARCHAR(255) DEFAULT NULL, critere VARCHAR(255) NOT NULL, observation VARCHAR(255) DEFAULT NULL, preconisation_conclusion VARCHAR(255) DEFAULT NULL, retenu VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, INDEX IDX_FD9FC2606358FF62 (parametre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE constat_electrique ADD CONSTRAINT FK_FD9FC2606358FF62 FOREIGN KEY (parametre_id) REFERENCES parametre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE constat_electrique DROP FOREIGN KEY FK_FD9FC2606358FF62');
        $this->addSql('DROP TABLE constat_electrique');
    }
}
