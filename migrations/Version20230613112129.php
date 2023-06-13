<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230613112129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mesure_isolement ADD tension1 DOUBLE PRECISION DEFAULT NULL, ADD tension2 DOUBLE PRECISION DEFAULT NULL, ADD tension3 DOUBLE PRECISION DEFAULT NULL, ADD tension4 DOUBLE PRECISION DEFAULT NULL, ADD tension5 DOUBLE PRECISION DEFAULT NULL, ADD tension6 DOUBLE PRECISION DEFAULT NULL, ADD tension7 DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mesure_isolement DROP tension1, DROP tension2, DROP tension3, DROP tension4, DROP tension5, DROP tension6, DROP tension7');
    }
}
