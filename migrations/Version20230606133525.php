<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606133525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE remontage_photo (id INT AUTO_INCREMENT NOT NULL, parametre_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_F89BCE3B6358FF62 (parametre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE remontage_photo ADD CONSTRAINT FK_F89BCE3B6358FF62 FOREIGN KEY (parametre_id) REFERENCES parametre (id)');
        $this->addSql('ALTER TABLE parametre ADD remontage TINYINT(1) DEFAULT NULL, ADD statut TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remontage_photo DROP FOREIGN KEY FK_F89BCE3B6358FF62');
        $this->addSql('DROP TABLE remontage_photo');
        $this->addSql('ALTER TABLE parametre DROP remontage, DROP statut');
    }
}
