<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605071527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appareil_mesure_mecanique (id INT AUTO_INCREMENT NOT NULL, parametre_id INT DEFAULT NULL, appareil_id INT DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, INDEX IDX_7EB9E84D6358FF62 (parametre_id), INDEX IDX_7EB9E84DBF6A0032 (appareil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appareil_mesure_mecanique ADD CONSTRAINT FK_7EB9E84D6358FF62 FOREIGN KEY (parametre_id) REFERENCES parametre (id)');
        $this->addSql('ALTER TABLE appareil_mesure_mecanique ADD CONSTRAINT FK_7EB9E84DBF6A0032 FOREIGN KEY (appareil_id) REFERENCES appareil (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appareil_mesure_mecanique DROP FOREIGN KEY FK_7EB9E84D6358FF62');
        $this->addSql('ALTER TABLE appareil_mesure_mecanique DROP FOREIGN KEY FK_7EB9E84DBF6A0032');
        $this->addSql('DROP TABLE appareil_mesure_mecanique');
    }
}
