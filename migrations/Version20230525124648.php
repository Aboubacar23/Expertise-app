<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230525124648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE point_fonctionnement (id INT AUTO_INCREMENT NOT NULL, parametre_id INT DEFAULT NULL, t DOUBLE PRECISION NOT NULL, u DOUBLE PRECISION NOT NULL, i1 DOUBLE PRECISION NOT NULL, i2 DOUBLE PRECISION NOT NULL, i3 DOUBLE PRECISION NOT NULL, p DOUBLE PRECISION NOT NULL, q DOUBLE PRECISION NOT NULL, cos DOUBLE PRECISION NOT NULL, n DOUBLE PRECISION NOT NULL, i DOUBLE PRECISION NOT NULL, tamb DOUBLE PRECISION NOT NULL, ca DOUBLE PRECISION NOT NULL, coa DOUBLE PRECISION NOT NULL, observation VARCHAR(255) DEFAULT NULL, INDEX IDX_D4C83B346358FF62 (parametre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE point_fonctionnement ADD CONSTRAINT FK_D4C83B346358FF62 FOREIGN KEY (parametre_id) REFERENCES parametre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE point_fonctionnement DROP FOREIGN KEY FK_D4C83B346358FF62');
        $this->addSql('DROP TABLE point_fonctionnement');
    }
}
