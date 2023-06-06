<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606114924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE remontage_palier (id INT AUTO_INCREMENT NOT NULL, caa DOUBLE PRECISION DEFAULT NULL, cab DOUBLE PRECISION DEFAULT NULL, cac DOUBLE PRECISION DEFAULT NULL, cad DOUBLE PRECISION DEFAULT NULL, ca_jeu DOUBLE PRECISION DEFAULT NULL, ca_roulement DOUBLE PRECISION DEFAULT NULL, type_graisse VARCHAR(255) DEFAULT NULL, coaa DOUBLE PRECISION DEFAULT NULL, coab DOUBLE PRECISION DEFAULT NULL, coac DOUBLE PRECISION DEFAULT NULL, coad DOUBLE PRECISION DEFAULT NULL, coa_jeu DOUBLE PRECISION DEFAULT NULL, coa_roulement DOUBLE PRECISION DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametre ADD remontage_palier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC790413FE54E6E FOREIGN KEY (remontage_palier_id) REFERENCES remontage_palier (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC790413FE54E6E ON parametre (remontage_palier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC790413FE54E6E');
        $this->addSql('DROP TABLE remontage_palier');
        $this->addSql('DROP INDEX UNIQ_ACC790413FE54E6E ON parametre');
        $this->addSql('ALTER TABLE parametre DROP remontage_palier_id');
    }
}
