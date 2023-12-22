<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Entity\Video;
use App\Entity\VideoWatch;
use App\Repository\VideoWatchRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

readonly class VideoService
{
    public function __construct(
        private VideoWatchRepository   $videoWatchRepository,
        private EntityManagerInterface $entityManager,
    )
    {
    }

    /**
     * @param object $video
     * @param User $user
     * @return void
     */
    public function addVideoWatch(Video $video, User $user): void
    {
        $currentDate = new DateTime();
        if ($this->videoWatchRepository->findOneBy(['video' => $video, 'user' => $user])) {
            $videoWatch = $this->videoWatchRepository->findOneBy(['video' => $video]);
            $videoWatch->setDate($currentDate);
        } else {
            $videoWatch = new VideoWatch();
            $videoWatch
                ->setVideo($video)
                ->setUser($user)
                ->setDate($currentDate);
        }
        $this->persistAndFlush($videoWatch);
    }

    /**
     * @param object $video
     * @param $kernelProjectDir
     * @return BinaryFileResponse
     */
    public function getVideoFile(object $video, $kernelProjectDir): BinaryFileResponse
    {
        return new BinaryFileResponse(
            $kernelProjectDir .
            '/uploads/' .
            $video->getOwner()->getId() .
            '/videos/' .
            $video->getFilename());
    }

    public function addView(object $video): void
    {
        $video->addView();

        $this->persistAndFlush($video);
    }

    /**
     * @param $entity
     * @return void
     */
    public function persistAndFlush($entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}