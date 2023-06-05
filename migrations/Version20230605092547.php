<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605092547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE releve_dimmensionnel (id INT AUTO_INCREMENT NOT NULL, parametre_id INT DEFAULT NULL, designation VARCHAR(255) NOT NULL, cote_attendue VARCHAR(255) NOT NULL, tolerance VARCHAR(255) NOT NULL, cote_relevee VARCHAR(255) NOT NULL, confirmite VARCHAR(255) NOT NULL, INDEX IDX_942D91666358FF62 (parametre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE releve_dimmensionnel ADD CONSTRAINT FK_942D91666358FF62 FOREIGN KEY (parametre_id) REFERENCES parametre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE releve_dimmensionnel DROP FOREIGN KEY FK_942D91666358FF62');
        $this->addSql('DROP TABLE releve_dimmensionnel');
    }
}
