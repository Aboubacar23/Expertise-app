<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230515124154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE affaire (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, code_client VARCHAR(255) NOT NULL, num_fabrication VARCHAR(255) NOT NULL, num_article_client VARCHAR(255) NOT NULL, context VARCHAR(255) DEFAULT NULL, num_affaire VARCHAR(255) NOT NULL, suivi_par VARCHAR(255) NOT NULL, date_livraison DATE NOT NULL, nom_rapport VARCHAR(255) NOT NULL, presentation_travaux LONGTEXT DEFAULT NULL, travaux_sup LONGTEXT DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, INDEX IDX_9C3F18EF19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE affaire ADD CONSTRAINT FK_9C3F18EF19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affaire DROP FOREIGN KEY FK_9C3F18EF19EB6921');
        $this->addSql('DROP TABLE affaire');
    }
}
