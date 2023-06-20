<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230620080919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lsonde_bobinage (id INT AUTO_INCREMENT NOT NULL, sonde_bobinage_id INT DEFAULT NULL, controle VARCHAR(255) NOT NULL, critere DOUBLE PRECISION NOT NULL, valeur_relevee DOUBLE PRECISION DEFAULT NULL, valeur DOUBLE PRECISION NOT NULL, conformite VARCHAR(255) NOT NULL, lig INT DEFAULT NULL, INDEX IDX_6F78041D1DCB46DC (sonde_bobinage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lsonde_bobinage ADD CONSTRAINT FK_6F78041D1DCB46DC FOREIGN KEY (sonde_bobinage_id) REFERENCES sonde_bobinage (id)');
        $this->addSql('ALTER TABLE sonde_bobinage DROP valeur1, DROP valeur2, DROP valeur3, DROP valeur4, DROP conformite1, DROP conformite2, DROP conformite3, DROP conformite4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lsonde_bobinage DROP FOREIGN KEY FK_6F78041D1DCB46DC');
        $this->addSql('DROP TABLE lsonde_bobinage');
        $this->addSql('ALTER TABLE sonde_bobinage ADD valeur1 DOUBLE PRECISION NOT NULL, ADD valeur2 DOUBLE PRECISION NOT NULL, ADD valeur3 DOUBLE PRECISION NOT NULL, ADD valeur4 DOUBLE PRECISION NOT NULL, ADD conformite1 VARCHAR(255) NOT NULL, ADD conformite2 VARCHAR(255) NOT NULL, ADD conformite3 VARCHAR(255) NOT NULL, ADD conformite4 VARCHAR(255) NOT NULL');
    }
}
