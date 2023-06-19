<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230619122608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lstator_apres_lavage (id INT AUTO_INCREMENT NOT NULL, stator_apres_lavage_id INT DEFAULT NULL, controle VARCHAR(255) NOT NULL, critere VARCHAR(255) NOT NULL, tension_essai DOUBLE PRECISION NOT NULL, valeur DOUBLE PRECISION NOT NULL, conformite VARCHAR(255) NOT NULL, lig INT DEFAULT NULL, INDEX IDX_B37809607CC92E5D (stator_apres_lavage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lstator_apres_lavage ADD CONSTRAINT FK_B37809607CC92E5D FOREIGN KEY (stator_apres_lavage_id) REFERENCES stator_apres_lavage (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lstator_apres_lavage DROP FOREIGN KEY FK_B37809607CC92E5D');
        $this->addSql('DROP TABLE lstator_apres_lavage');
    }
}
