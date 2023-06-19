<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230619110410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lmesure_resistance (id INT AUTO_INCREMENT NOT NULL, mesure_resistance_id INT DEFAULT NULL, controle VARCHAR(255) NOT NULL, critere DOUBLE PRECISION NOT NULL, valeur DOUBLE PRECISION NOT NULL, conformite VARCHAR(255) NOT NULL, lig INT DEFAULT NULL, INDEX IDX_AD1EA0C6BD989507 (mesure_resistance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lmesure_resistance ADD CONSTRAINT FK_AD1EA0C6BD989507 FOREIGN KEY (mesure_resistance_id) REFERENCES mesure_resistance (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lmesure_resistance DROP FOREIGN KEY FK_AD1EA0C6BD989507');
        $this->addSql('DROP TABLE lmesure_resistance');
    }
}
